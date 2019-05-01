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

require_once __DIR__."/Base.php";

use GuzzleHttp\Psr7\Request;

/**
 * PROPFIND的请求封装
 * Class PropfindOperate
 * @package OwnCloudeSDK\Connection
 */
class PropfindOperate extends Base
{
    /**
     * propfind请求，常用语获取指定目录下的文件列表
     * @param $searchDir string 对应的目录
     * @param bool $isHttps 是否是https
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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