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

trait Base{
    public function getException(\Exception $e){
        return $e->getMessage()."-".$e->getFile()."-".$e->getLine();
    }
    public function getConfigData(){
        return require_once __DIR__."/../Config.php";
    }
}