<?php
/**
 * File name: UploadFile.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-02
 *   Author:
 *   Modification
 */
namespace OwnCloudeSDK\Operate;

use OwnCloudeSDK\Connection\PutOperate;
use OwnCloudeSDK\Exception\FolderNotExist;
use OwnCloudeSDK\Exception\UnlegalName;

require_once __DIR__."/../Connection/PutOperate.php";
require_once __DIR__."/../Exceptions/UnlegalName.php";
require_once __DIR__."/Base.php";
require_once __DIR__."/FilePath.php";
require_once __DIR__."/../Exceptions/FolderNotExist.php";

class UploadFile extends Base{
    const API="/remote.php/webdav";

    /**
     * 文件上传
     * @param $savePath string 文件在云盘中的地址
     * @param $uploadFilePath string 待上传的文件地址，支持http协议或者本地文件
     * @param $fileName string 文件名
     * @param bool $isAllowSameFileName 是否允许上传同名文件，如果允许，则存在同名文件时，会在其后加数字
     * @throws UnlegalName
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws FolderNotExist
     */
    public function upload($savePath,$uploadFilePath,$fileName,$isAllowSameFileName=false){
        // 文件名检查
        if(!self::checkSpecialFileName($fileName)){
            throw new UnlegalName("文件名中存在非法字段");
        }
        $url=$this->domain.self::API.$savePath."/".$fileName;
        $putOperate=new PutOperate(
            $this->userName,
            $this->password
        );
        $result=$putOperate->put(
            $url,
            $uploadFilePath,
            $this->isHttps
        );
        if(!$result['result']){
            if(intval($result['data'])==204 && $isAllowSameFileName){
                // 存在同名文件且设置开启允许上传同名文件，则修改文件名再上传一次
                // 首先获取对应文件夹下文件列表
                $folder=new FilePath(
                    $this->domain,
                    $this->userName,
                    $this->password,
                    $this->isHttps
                );
                $folderInfo=$folder->getFilePath($savePath);
                $uniqueFileName=self::getUniqueName($fileName,$folderInfo);
                // 将最后一个值设置为 false，防止代码陷入死循环，而且理论上，重新生成文件名后，不会再出现上传失败的问题
                $this->upload($savePath,$uploadFilePath,$uniqueFileName);
                return ;
            }
            if(intval($result['data'])==404){
                throw new FolderNotExist("文件上传目录不存在");
            }
            throw new \Exception($result['message']);
        }
    }
}