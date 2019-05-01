<?php
/**
 * File name: PropfindOperate.php
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

class PropfindOperate extends Base
{
    public function propfind($searchDir,$isHttps){
        $fullUrl=$this->getUrlPrefix($searchDir,$isHttps);
        try{
            $client=self::getClient();
            $request=new Request("PROPFIND",$fullUrl);
            $response=$client->send($request);
            return self::returnResult(true,"",$response->getBody()->getContents());
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage());
        }
    }
}