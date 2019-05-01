<?php
/**
 * File name: FilePathTest.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */
namespace OwnCloudeSDK\test;

use OwnCloudeSDK\Operate\FilePath;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/Base.php";
require_once __DIR__."/../Operate/FilePath.php";

class FilePathTest extends Base {
    public function testGetFilePath(){
        $filePath=new FilePath(
            $this->domain,
            $this->userName,
            $this->password,
            $this->isHttps
        );
        try{
            $filePathData=$filePath->getFilePath();
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
        $this->assertTrue(true);
    }
}