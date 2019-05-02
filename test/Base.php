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
    /**
     * 为了方便调试而采用的辅助类
     * @param \Exception $e
     * @return string
     */
    public function getException(\Exception $e){
        return $e->getMessage()."-".$e->getFile()."-".$e->getLine();
    }

    /**
     * 读取配置值
     * @return array
     */
    public function getConfigData(){
        return array(
            'domain'=>"",// owncloud的域名
            'user_name'=>"",// 对应的owncloud用户名
            'password'=>"",// 对应的owncloud的密码
            'is_https'=>true,// owncloud的域名是否使用了ca证书
            'another_user_name'=>""// 另一个owncloud的账号，主要是用于进行文件分享测试的
        );
    }
}