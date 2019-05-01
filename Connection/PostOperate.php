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


use GuzzleHttp\Psr7\Request;

class PostOperate extends Base
{
    public function post($url,$isHttps,$postData){
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