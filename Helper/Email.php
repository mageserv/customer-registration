<?php
/**
 * Email
 *
 * @copyright Copyright © 2023 Mageserv LTD. All rights reserved.
 * @author    mageserv.ltd@gmail.com
 */
namespace Mageserv\CustomerRegistration\Helper;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Email extends AbstractHelper
{
    const CUSTOMER_SERVICE_EMAIL_XML_PATH = "customer_registration/general/cs_email";
    const CUSTOMER_SERVICE_EMAIL_TEMPLATE_XML_PATH = "customer_registration/general/template";
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;
    /**
     * @var Escaper
     */
    protected $escaper;
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
    }

    public function getCustomerServiceEmail()
    {
        return $this->scopeConfig->getValue(
            self::CUSTOMER_SERVICE_EMAIL_XML_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }
    public function getCustomerServiceEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::CUSTOMER_SERVICE_EMAIL_TEMPLATE_XML_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }
    public function sendEmail(CustomerInterface $customer): void
    {
        if(!$this->getCustomerServiceEmail()){
            $this->_logger->critical(__("Customer Registration module is not configured correctly, Please add customer service email."));
            return;
        }
        try {
            $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
            if($customer->getStoreId())
                $storeId = $customer->getStoreId();

            $store = $this->storeManager->getStore($storeId);
            $this->inlineTranslation->suspend();
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->getCustomerServiceEmailTemplate())
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $storeId,
                    ]
                )
                ->setTemplateVars([
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'customer'  => $customer,
                    'store' => $store
                ])
                ->setFrom($this->scopeConfig->getValue('trans_email/ident_general/email'))
                ->addTo($this->getCustomerServiceEmail())
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->debug($e->getMessage());
        }
    }
}
