# Customer Registration - Magento

---

## Installation

### Install using FTP method


1. Download the latest release of the plugin
2. Upload the content of the folder to magento2 installation directory: `app/code/Mageserv/CustomerRegistration`
3. Run the following Magento commands:
   1. `php bin/magento setup:upgrade`
   2. `php bin/magento setup:static-content:deploy`
   3. `php bin/magento cache:clean`

### Install using `Composer`

1. `composer require mageserv/cutomer-registration`
2. `php bin/magento setup:upgrade`
3. `php bin/magento setup:static-content:deploy`
4. `php bin/magento cache:clean`

---

## Activating the Plugin

By default, and after installing the module, it will be activated.
To Disable/Enable the module:

### Enable

`php bin/magento module:enable Mageserv_CustomerRegistration`

### Disable

`php bin/magento module:disable Mageserv_CustomerRegistration`

---

## Configure the Plugin

1. Navigate to `"Magento admin panel" >> Stores >> Configuration`
2. Open `"Elaraby Group >> Customer Registration`
3. Enable the module and add your configurations
4. Click `Save Config`

---

## Log Access


1. Access log from file found at: `/var/log/customer-{id}.log`

---

Done
