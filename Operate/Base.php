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
namespace OwnCloudeSDK\Operate;

class Base{
    protected $domain;
    protected $userName;
    protected $password;
    protected $isHttps;

    /**
     * Base constructor.
     * @param $domain string 对应的域名
     * @param $userName string 当前操作用于的ownclound账号
     * @param $password string 当前人员的密码
     * @param $isHttps bool 该域名是否配置了CA证书
     */
    public function __construct($domain,$userName,$password,$isHttps)
    {
        $this->domain=$domain;
        $this->userName=$userName;
        $this->password=$password;
        $this->isHttps=$isHttps;
    }

    /**
     * 检查文件夹，文件名中是否有特殊字符串，如果有则视为异常
     * @param $fileName
     * @return bool
     */
    protected static function checkSpecialFileName($fileName){
        if(strpos($fileName,"&")){
            return false;
        }
        return true;
    }
}