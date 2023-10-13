<?php
/**
 * Data
 *
 * @copyright Copyright © 2023 Mageserv LTD. All rights reserved.
 * @author    mageserv.ltd@gmail.com
 */
namespace Mageserv\CustomerRegistration\Helper;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Mageserv\CustomerRegistration\Logger\Logger;

class Data extends AbstractHelper
{
    const CUSTOMER_REGISTRATION_ENABLE_XML_PATH = "customer_registration/general/enable";

    public function isEnabled($scope = ScopeInterface::SCOPE_STORES, $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::CUSTOMER_REGISTRATION_ENABLE_XML_PATH,
            $scope,
            $storeId
        );
    }

    public function log(CustomerInterface $customer): void
    {
        if(!$this->isEnabled() || !$customer->getId())
            return;

        $logFileName =  "customer-" . $customer->getId();
        $logger = new Logger($logFileName);
        $customerData = [
            "first_name" => $customer->getFirstname(),
            "last_name" => $customer->getLastname(),
            "email" => $customer->getEmail(),
            "created_at" => $customer->getCreatedAt(),
            "current_date" => date('Y-m-d H:i:s')
        ];
        $logger->info(
            print_r($customerData, true)
        );
    }
}
