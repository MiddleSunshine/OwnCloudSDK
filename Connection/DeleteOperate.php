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


class DeleteOperate extends Base
{
    public function delete($deleteFolder,$isHttps){
        try{
            $fullUrl=$this->getUrlPrefix($deleteFolder,$isHttps);
            $client=self::getClient();
            $client->delete($fullUrl);
            return self::returnResult();
        }catch (\Exception $e){
            return self::returnResult(false,"删除操作执行失败",$e->getMessage());
        }
    }
}