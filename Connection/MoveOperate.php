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

require_once __DIR__."/Base.php";

use GuzzleHttp\Psr7\Request;

/**
 * move请求的封装
 * Class MoveOperate
 * @package OwnCloudeSDK\Connection
 */
class MoveOperate extends Base
{
    /**
     * move请求，常用于移动文件或者文件夹
     * @param $originalPath string 源文件地址
     * @param $newPath string 新地址，如果该地址不存在，不支持自动创建
     * @param bool $isHttps 是否是https
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function move($originalPath,$newPath,$isHttps=true){
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