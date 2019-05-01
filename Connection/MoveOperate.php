<?php
/**
 * File name: MoveOperate.php
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

class MoveOperate extends Base
{
    public function move($originalPath,$newPath,$isHttps){
        $fullUrl=$this->getUrlPrefix($originalPath,$isHttps);
        $header=array(
            'Destination'=>$this->getUrlPrefix($newPath,$isHttps)
        );
        try{
            $client=self::getClient();
            $request=new Request("Move",$fullUrl,$header);
            $client->send($request);
            return self::returnResult();
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage());
        }
    }
}