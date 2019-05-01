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

require_once __DIR__."/Base.php";

/**
 * Put请求的封装
 * Class PutOperate
 * @package OwnCloudeSDK\Connection
 */
class PutOperate extends Base
{
    /**
     * put请求，常用语上传文件
     * @param $url string 对应的文件上传目录
     * @param $filePath string 待上传文件的路径，只是http协议获取或者本地文件
     * @param bool $isHttps 是否是https
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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