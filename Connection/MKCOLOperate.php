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


use GuzzleHttp\Psr7\Request;

class MKCOLOperate extends Base
{
    public function mkcol($url,$isHttps){
        $fullUrl=$this->getUrlPrefix($url,$isHttps);
        $client=self::getClient();
        try{
            $request=new Request("MKCOL",$fullUrl);
            $client->send($request);
            return self::returnResult();
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage());
        }
    }
}