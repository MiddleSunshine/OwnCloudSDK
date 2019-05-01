<?php
/**
 * File name: PutOperate.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Connection;


class PutOperate extends Base
{
    public function put($url,$filePath,$isHttps){
        $fullUrl=$this->getUrlPrefix($url,$isHttps);
        $body=file_get_contents($filePath);
        if(!$body){
            return self::returnResult(false,"文件地址错误");
        }
        $header=array(
            'Content-Type'=>"multiple/form-data"
        );
        try{
            $client=self::getClient();
            $response=$client->request(
                'PUT',
                $fullUrl,
                [
                    'header'=>$header,
                    'body'=>$body
                ]
            );
            $returnStatus=intval($response->getStatusCode());
            if($returnStatus==204){
                return self::returnResult(false,"重名文件已存在");
            }
            return self::returnResult();
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage());
        }
    }
}