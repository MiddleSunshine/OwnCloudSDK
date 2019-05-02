<?php
/**
 * File name: Folder.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-02
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Operate;

use OwnCloudeSDK\Connection\DeleteOperate;
use OwnCloudeSDK\Connection\MKCOLOperate;
use OwnCloudeSDK\Exception\FolderExist;
use OwnCloudeSDK\Exception\FolderNotExist;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Connection/MKCOLOperate.php";
require_once __DIR__."/../Connection/DeleteOperate.php";
require_once __DIR__."/../Exceptions/FolderExist.php";
require_once __DIR__."/../Exceptions/FolderNotExist.php";

class Folder extends Base
{
    const API="/remote.php/webdav";
    protected static $mkcol;
    protected static $delete;
    protected function getMKCOL(){
        if(!self::$mkcol){
            self::$mkcol=new MKCOLOperate(
                $this->userName,
                $this->password
            );
        }
        return self::$mkcol;
    }
    protected function getDelete(){
        if(!self::$delete){
            self::$delete=new DeleteOperate(
                $this->userName,
                $this->password
            );
        }
        return self::$delete;
    }
    /**
     * 创建对应的文件夹
     * @param $folderFullName string 对应的完整路径，比如 /新建文件夹
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws FolderExist
     */
    public function createFolder($folderFullName) {
        $url=$this->domain.self::API.$folderFullName;
        $mkcol=$this->getMKCOL();
        $result=$mkcol->mkcol($url,$this->isHttps);
        if(!$result['result']){
            // 如果返回码是 405 则表示目录已存在
            if(intval($result['data'])==405){
                throw new FolderExist($folderFullName."目录已存在");
            }
            throw new \Exception($result['message']);
        }
    }

    /**
     * 删除对应的文件夹
     * @param $folderFullName string 待删除的文件夹
     * @throws \Exception
     * @throws FolderNotExist
     */
    public function deleteFolder($folderFullName){
        $url=$this->domain.self::API.$folderFullName;
        $delete=$this->getDelete();
        $result=$delete->delete($url,$this->isHttps);
        if(!$result['result']){
            if(intval($result['data'])==404){
                throw new FolderNotExist($folderFullName."目录不存在");
            }
            throw new \Exception($result['message']);
        }
    }
}