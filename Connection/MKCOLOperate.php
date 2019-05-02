<?php
/**
 * File name: MKCOLOperate.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Connection;

require_once __DIR__."/Base.php";

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;

/**
 * MKCOL请求封装
 * Class MKCOLOperate
 * @package OwnCloudeSDK\Connection
 */
class MKCOLOperate extends Base
{
    /**
     * 创建对应目录的请求封装
     * @param $url string 对应的路径
     * @param bool $isHttps 是否是https请求
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function mkcol($url,$isHttps=true){
        $fullUrl=$this->getUrlPrefix($url,$isHttps);
        $client=self::getClient();
        try{
            $request=new Request("MKCOL",$fullUrl);
            $client->send($request);
            return self::returnResult();
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage(),$e->getCode());
        }
    }
}