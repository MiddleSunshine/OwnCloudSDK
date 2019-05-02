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
use OwnCloudeSDK\Exception\UnlegalName;

require_once __DIR__."/../Connection/PutOperate.php";
require_once __DIR__."/../Exceptions/UnlegalName.php";
require_once __DIR__."/Base.php";

class UploadFile extends Base{
    const API="/remote.php/webdav";

    /**
     * 文件上传
     * @param $savePath string 文件在云盘中的地址
     * @param $uploadFilePath string 待上传的文件地址，支持http协议或者本地文件
     * @param $fileName string 文件名
     * @throws UnlegalName
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload($savePath,$uploadFilePath,$fileName){
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
            throw new \Exception($result['message']);
        }
    }
}