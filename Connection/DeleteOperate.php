<?php
/**
 * File name: DeleteOperate.php
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
 * Delete请求封装
 * Class DeleteOperate
 * @package OwnCloudeSDK\Connection
 */
class DeleteOperate extends Base
{
    /**
     * 删除请求
     * @param $deleteFolder string 待删除的文件路径或者文件目录
     * @param bool $isHttps 是否是https的请求
     * @return array
     */
    public function delete($deleteFolder,$isHttps=true){
        try{
            $fullUrl=$this->getUrlPrefix($deleteFolder,$isHttps);
            $client=self::getClient();
            $client->delete($fullUrl);
            return self::returnResult();
        }catch (\Exception $e){
            return self::returnResult(false,$e->getMessage(),$e->getCode());
        }
    }
}