<?php
/**
 * File name: File.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Operate;


class File
{
    public $filePath;
    public $fileType;
    public $createTime;
    public $fileName;
    public $usedBytes;
    public $availableBytes=0;
    public $isFolder=true;
    public function toArray(){
        return array(
            'file_path'=>$this->filePath,
            'file_type'=>$this->fileType,
            'create_time'=>$this->createTime,
            'file_name'=>$this->fileName,
            'used_bytes'=>$this->usedBytes,
            'available_bytes'=>$this->availableBytes,
            'is_folder'=>$this->isFolder
        );
    }
}