<?php
/**
 * Created by PhpStorm.
 * User: yangqingxian
 * Date: 2018/10/15
 * Time: 下午9:40
 */
namespace OwnCludeSDK\Model;

class BaseModel{
    protected $user_name;
    protected $password;
    protected $serverName;
    /**
     * 构造方法，需要传入对应的服务器名，用户名与密码
     * BaseModel constructor.
     * @param $user_name
     * @param $password
     * @param $serverName
     */
    public function __construct($user_name,$password,$serverName)
    {
        $this->user_name=$user_name;
        $this->password=$password;
        $this->serverName=$serverName;
    }
    /**
     * 根据用户名与密码拼接请求地址
     * @param $url
     * @param bool $isHttps
     * @return string
     */
    protected function getUrlPrefix($url,$isHttps=true){
        if($isHttps){
            return "https://".$this->user_name.":".$this->password.$this->serverName.$url;
        }else{
            return "http://".$this->user_name.":".$this->password.$this->serverName.$url;
        }
    }
}

