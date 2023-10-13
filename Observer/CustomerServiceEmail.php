<?php
/**
 * CustomerServiceEmail
 *
 * @copyright Copyright © 2023 Mageserv LTD. All rights reserved.
 * @author    mageserv.ltd@gmail.com
 */
namespace Mageserv\CustomerRegistration\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mageserv\CustomerRegistration\Helper\Data as AppHelper;
use Mageserv\CustomerRegistration\Helper\Email as EmailHelper;
class CustomerServiceEmail implements ObserverInterface
{
    public function __construct(
        protected AppHelper $appHelper,
        protected EmailHelper $emailHelper
    )
    {}

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var  $customer */
        $customer = $observer->getEvent()->getCustomer();
        if($customer->getId() && $this->appHelper->isEnabled()){
            $this->appHelper->log($customer);
            $this->emailHelper->sendEmail($customer);
        }
    }
}
