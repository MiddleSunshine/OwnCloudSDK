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
use OwnCloudeSDK\Connection\MoveOperate;
use OwnCloudeSDK\Exception\FolderExist;
use OwnCloudeSDK\Exception\FolderNotExist;
use OwnCloudeSDK\Exception\UnlegalName;
use OwnCloudeSDK\Exception\WrongPath;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Connection/MKCOLOperate.php";
require_once __DIR__."/../Connection/DeleteOperate.php";
require_once __DIR__."/../Connection/MoveOperate.php";
require_once __DIR__."/../Exceptions/FolderExist.php";
require_once __DIR__."/../Exceptions/FolderNotExist.php";
require_once __DIR__."/../Exceptions/UnlegalName.php";
require_once __DIR__."/../Exceptions/WrongPath.php";

class Folder extends Base
{
    const API="/remote.php/webdav";
    protected static $mkcol;
    protected static $delete;
    protected static $move;
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
    protected function getMove(){
        if(!self::$move){
            self::$move=new MoveOperate(
                $this->userName,
                $this->password
            );
        }
        return self::$move;
    }
    /**
     * 创建对应的文件夹
     * @param $folderFullName string 对应的完整路径，比如 /新建文件夹
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws FolderExist
     * @throws UnlegalName
     * @throws WrongPath
     */
    public function createFolder($folderFullName) {
        if(!self::checkSpecialFileName($folderFullName)){
            throw new UnlegalName("当前目录中存在非法字段");
        }
        $url=$this->domain.self::API.$folderFullName;
        $mkcol=$this->getMKCOL();
        $result=$mkcol->mkcol($url,$this->isHttps);
        if(!$result['result']){
            // 如果返回码是 405 则表示目录已存在
            if(intval($result['data'])==405){
                throw new FolderExist($folderFullName."目录已存在");
            }
            if(intval($result['data'])==409){
                throw new WrongPath("系统暂时不支持创建多级目录");
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

    /**
     * 移动对应的文件夹
     * @param $nowFolderDir string 原始文件夹路径
     * @param $newFolderDir string 待移动的文件夹路径
     * @throws UnlegalName
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws WrongPath
     */
    public function moveFolder($nowFolderDir,$newFolderDir){
        if($nowFolderDir==$newFolderDir){
            throw new WrongPath("不允许在同一目录中移动");
        }
        if(!self::checkSpecialFileName($newFolderDir)){
            throw new UnlegalName("新目录存在非法字符串");
        }
        // 移动后地址
        $nextUrl=$this->domain.self::API.$newFolderDir.$nowFolderDir;
        $nowUrl=$this->domain.self::API.$nowFolderDir;
        $move=$this->getMove();
        $result=$move->move($nowUrl,$nextUrl,$this->isHttps);
        if(!$result['result']){
            if(intval($result['data'])==409){
                throw new WrongPath("待移动目录不存在");
            }
            throw new \Exception($result['message']);
        }
    }
}