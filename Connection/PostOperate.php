<?php
/**
 * File name: PostOperate.php
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
 * POST请求封装
 * Class PostOperate
 * @package OwnCloudeSDK\Connection
 */
class PostOperate extends Base
{
    /**
     * post请求
     * @param $url string post文件地址
     * @param $postData array post数据
     * @param bool $isHttps 是否是https
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($url,$postData,$isHttps=true){
        $fullUrl=$this->getUrlPrefix($url,$isHttps);
        try{
            $client=self::getClient();
            $request=new Request("POST",$fullUrl);
            $client->send($request,['form_params'=>$postData]);
            return self::returnResult();
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage());
        }
    }
}