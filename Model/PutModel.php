<?php
/**
 * Created by PhpStorm.
 * User: yangqingxian
 * Date: 2018/10/15
 * Time: 下午9:43
 */
namespace OwnCludeSDK\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class PutModel extends BaseModel{
    /**
     * 封装了PUT方法
     * @param $url
     * @param $isHttps
     * @return string
     */
    public function Put($url,$isHttps){
        $fullUrl=$this->getUrlPrefix($url,$isHttps);
        $client=new Client(['base_url'=>$fullUrl]);
        try{
            $response=$client->put($fullUrl);
            $xmlString=$response->getBody()->getContents();
            return $xmlString;
        }catch (ClientException $e) {
            return "";
        }
    }
}