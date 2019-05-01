<?php
/**
 * File name: GetOperate.php
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

/**
 * Get请求封装
 * Class GetOperate
 * @package OwnCloudeSDK\Connection
 */
class GetOperate extends Base
{
    /**
     * 获取数据的请求
     * @param $url string 对应的请求地址
     * @param bool $isHttps 是否是https
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url,$isHttps=true){
        $fullUrl=$this->getUrlPrefix($url,$isHttps);
        $client=self::getClient();
        $request=new Request("GET",$fullUrl);
        try{
            $response=$client->send($request);
            return self::returnResult(true,"",$response);
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage());
        }
    }
}