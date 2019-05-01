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
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Operate/FilePath.php";
require_once __DIR__."/Base.php";

class FilePathTest extends TestCase {
    use Base;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetFilePath(){
        // TODO 配置文件没有生效，所以导致下面的代码错误了
        p($GLOBALS);
        try{
            $filePath=new FilePath(
                $GLOBALS['domain'],
                $GLOBALS['user_name'],
                $GLOBALS['password'],
                $GLOBALS['is_https']
            );
            $filePathData=$filePath->getFilePath();
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
        $this->assertTrue(true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSearch(){
        try{
            $filePath=new FilePath(
                $GLOBALS['domain'],
                $GLOBALS['user_name'],
                $GLOBALS['password'],
                $GLOBALS['is_https']
            );
            $filePath->search("/","Do");
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
        $this->assertTrue(true);
    }
}