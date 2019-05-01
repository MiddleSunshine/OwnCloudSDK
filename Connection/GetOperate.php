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


use http\Client\Request;

class GetOperate extends Base
{
    public function get($url,$isHttps){
        $fullUrl=$this->getUrlPrefix($url,$isHttps);
        $client=self::getClient();
        $request=new Request("GET",$fullUrl);
        try{
            $response=$client->send($request);
            return self::returnResult(true,"",$response);
        }catch (\Exception $e){
            return self::returnResult(false,"",$e->getMessage());
        }
    }
}