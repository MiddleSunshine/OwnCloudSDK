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
            'domain'=>"",
            'user_name'=>"",
            'password'=>"",
            'is_https'=>true
        );
    }
}