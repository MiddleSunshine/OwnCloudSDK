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

require_once __DIR__."/../vendor/autoload.php";

class Base extends TestCase {
    public function getException(\Exception $e){
        return $e->getMessage()."-".$e->getFile()."-".$e->getLine();
    }
    public function getConfigData(){
        return array(
            'domain'=>"pdtowncloud.pewinner.com",
            'user_name'=>"admin",
            'password'=>"admin",
            'is_https'=>true,
            'another_user_name'=>"owncloud"
        );
    }
}