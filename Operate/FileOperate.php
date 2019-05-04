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

use OwnCloudeSDK\Connection\DeleteOperate;
use OwnCloudeSDK\Connection\MoveOperate;
use OwnCloudeSDK\Exception\FileNotExist;
use OwnCloudeSDK\Exception\FolderNotExist;
use OwnCloudeSDK\Exception\UnlegalName;
use OwnCloudeSDK\Exception\WrongPath;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Connection/DeleteOperate.php";
require_once __DIR__."/../Connection/MoveOperate.php";
require_once __DIR__."/../Exceptions/FolderNotExist.php";
require_once __DIR__."/../Exceptions/UnlegalName.php";
require_once __DIR__."/../Exceptions/WrongPath.php";
require_once __DIR__."/../Exceptions/FileNotExist.php";

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

    /**
     * 移动文件，注意，如果待移动目录下有同名文件，则会出现覆盖情况
     * @param $originalFilePath string 文件原始路径
     * @param $newFilePath string 新文件路径
     * @param $fileName string 文件名
     * @throws WrongPath
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws FileNotExist
     */
    public function moveFile($originalFilePath,$newFilePath,$fileName){
        if($originalFilePath==$newFilePath){
            // 在同一个目录下移动，则不报错
            return ;
        }
        $url=$this->domain.self::API.$originalFilePath.$fileName;
        $nextUrl=$this->domain.self::API.$newFilePath.$fileName;
        $move=new MoveOperate(
            $this->userName,
            $this->password
        );
        $result=$move->move(
            $url,
            $nextUrl,
            $this->isHttps
        );
        if(!$result['result']){
            if(intval($result['data'])==404){
                throw new FileNotExist($originalFilePath.$fileName."该文件不存在");
            }
            if(intval($result['data'])==409){
                throw new WrongPath("待移动目录不存在");
            }
            throw new \Exception($result['message']);
        }
    }

    /**
     * 删除指定目录下文件
     * @param $fileFullPath string 文件完整路径
     * @throws FileNotExist
     */
    public function deleteFile($fileFullPath){
        $url=$this->domain.self::API.$fileFullPath;
        $delete=new DeleteOperate(
            $this->userName,
            $this->password
        );
        $result=$delete->delete($url,$this->isHttps);
        if(!$result['result']){
            if(intval($result['data'])==404){
                throw new FileNotExist($fileFullPath."该文件不存在");
            }
            throw new \Exception($result['message']);
        }
    }
}