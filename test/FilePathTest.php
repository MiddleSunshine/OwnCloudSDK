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

require_once __DIR__."/../Operate/FilePath.php";
require_once __DIR__."/Base.php";

class FilePathTest extends Base {

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetFilePath(){
        $config=$this->getConfigData();
        try{
            $filePath=new FilePath(
                $config['domain'],
                $config['user_name'],
                $config['password'],
                $config['is_https']
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
        $config=$this->getConfigData();
        try{
            $filePath=new FilePath(
                $config['domain'],
                $config['user_name'],
                $config['password'],
                $config['is_https']
            );
            $filePath->search("/","Do");
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
        $this->assertTrue(true);
    }
}