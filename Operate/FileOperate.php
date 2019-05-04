<?php
/**
 * File name: FileOperate.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-03
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Operate;

use OwnCloudeSDK\Connection\MoveOperate;
use OwnCloudeSDK\Exception\FolderNotExist;
use OwnCloudeSDK\Exception\UnlegalName;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Connection/DeleteOperate.php";
require_once __DIR__."/../Connection/MoveOperate.php";
require_once __DIR__."/../Exceptions/FolderNotExist.php";
require_once __DIR__."/../Exceptions/UnlegalName.php";
require_once __DIR__."/../Exceptions/WrongPath.php";

class FileOperate extends Base
{
    const API="/remote.php/webdav";

    /**
     * 重命名文件，注意，如果相同目录下存在重命名后重名文件，则会覆盖老文件
     * @param $filePath
     * @param $fileName
     * @param $newFileName
     * @throws FolderNotExist
     * @throws UnlegalName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function renameFile($filePath,$fileName,$newFileName){
        if($fileName==$newFileName){
            return ;// 设置同名文件不报异常，因为这个操作成功和失败都是一样的结果
        }
        if(!self::checkSpecialFileName($newFileName)){
            throw new UnlegalName("文件名存在非法字段");
        }
        $nextUrl=$this->domain.self::API.$filePath.$newFileName;
        $nowUrl=$this->domain.self::API.$filePath.$fileName;
        $move=new MoveOperate(
            $this->userName,
            $this->password
        );
        $result=$move->move($nowUrl,$nextUrl,$this->isHttps);
        if(!$result['result']){
            if(intval($result['data'])==404){
                throw new FolderNotExist(
                    $filePath."路径下{$fileName}文件不存在"
                );
            }
            throw new \Exception($result['message']);
        }
    }
    public function moveFile(){

    }
    public function deleteFile(){

    }
}