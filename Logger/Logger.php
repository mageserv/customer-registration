<?php
/**
 * Ishaarat WA Notifications.
 *
 *
 * @category  Ishaarat
 * @package   Ishaarat_WANotifications
 * @author    Ishaarat <support@ishaarat.com>
 * @copyright 2023 (https://ishaarat.com)
 */

namespace Mageserv\CustomerRegistration\Logger;

use Magento\Framework\Filesystem\Driver\File as FileSystem;
use Magento\Framework\Logger\Handler\Base as BaseHandler;

class Logger extends \Monolog\Logger
{
    public function __construct($filename)
    {
        $handler = new BaseHandler(new FileSystem(), null, "/var/log/" . $filename . ".log");
        parent::__construct('CustomerRegistrations', [$handler]);
    }

}
