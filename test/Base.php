<?php
/**
 * File name: Base.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */
namespace OwnCloudeSDK\test;

use PHPUnit\Framework\TestCase;

class Base extends TestCase {
    protected $domain="";
    protected $userName="";
    protected $password="";
    protected $isHttps;
    protected function setUp(): void
    {
        $config=require_once __DIR__."/../Config.php";
        $this->domain=$config['domain'];
        $this->userName=$config['user_name'];
        $this->password=$config['password'];
        $this->isHttps=$config['is_https'];
    }
}