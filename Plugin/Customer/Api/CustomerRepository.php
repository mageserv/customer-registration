<?php
/**
 * CustomerRepository
 *
 * @copyright Copyright © 2023 Mageserv LTD. All rights reserved.
 * @author    mageserv.ltd@gmail.com
 */

namespace Mageserv\CustomerRegistration\Plugin\Customer\Api;

use Magento\Customer\Api\Data\CustomerInterface;

class CustomerRepository
{
    public function beforeSave(
        \Magento\Customer\Model\ResourceModel\CustomerRepository $subject,
        CustomerInterface $customer,
        $passwordHash = null
    )
    {
        if (!$customer->getId() && $firstName = $customer->getFirstName()) {
            $firstName = str_replace(' ', '', $firstName);
            $customer->setFirstName($firstName);
        }
        return [$customer, $passwordHash];
    }
}
