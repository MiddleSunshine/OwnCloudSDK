<?php
/**
 * File name: FolderTest.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-02
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\test;

use OwnCloudeSDK\Operate\Folder;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Operate/Folder.php";

class FolderTest extends Base
{
    private $folderName="/TestFolder";

    public function testCreateFolder(){
        $config=$this->getConfigData();
        $folder=new Folder(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        try{
            $folder->createFolder("/".$this->folderName);
            $this->assertTrue(true);
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }
    public function testDeleteFolder(){
        $config=$this->getConfigData();
        $folder=new Folder(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        try{
            $folder->deleteFolder("/".$this->folderName);
            $this->assertTrue(true);
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }
}