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
namespace OwnCloudeSDK\Connection;

use GuzzleHttp\Client;

class Base{
    protected $userName;
    protected $password;
    protected static $client;
    public function __construct($userName,$password)
    {
        $this->userName=$userName;
        $this->password=$password;
    }
    protected function getUrlPrefix($url,$isHttps=true){
        return ($isHttps?"https":"http")."//".$this->userName.":".$this->password."@".$url;
    }
    protected static function returnResult($result=true,$message="",$data=null){
        return array(
            'result'=>$result,
            'message'=>$message,
            'data'=>$data
        );
    }
    protected static function getClient(){
        if(!self::$client){
            self::$client=new Client();
        }
        return self::$client;
    }
}