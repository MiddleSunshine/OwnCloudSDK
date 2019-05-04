<?php
/**
 * File name: FileOperateTest.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-03
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\test;


use OwnCloudeSDK\Exception\FolderNotExist;
use OwnCloudeSDK\Exception\UnlegalName;
use OwnCloudeSDK\Operate\FileOperate;
use OwnCloudeSDK\Operate\UploadFile;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Operate/UploadFile.php";
require_once __DIR__."/../Operate/FileOperate.php";

class FileOperateTest extends Base
{
    private $uploadFileName="RenameFile.html";
    private $renameFile="RenameFileSuccess.html";
    public function setUp(): void
    {
        // 设置重命名文件
        $uploadFilePath=__DIR__."/".$this->uploadFileName;
        $config=$this->getConfigData();
        $uploadFile=new UploadFile(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        try{
            $uploadFile->upload(
                "/",
                $uploadFilePath,
                $this->uploadFileName
            );
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }

    public function testRenameFile(){
        $config=$this->getConfigData();
        $fileOperate=new FileOperate(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        try{
            $fileOperate->renameFile(
                "/",
                $this->uploadFileName,
                $this->renameFile
            );
            $this->assertTrue(true);
        }catch (FolderNotExist $e){
            $this->assertTrue(false,"对应路径下文件不存在");
        }
        catch (UnlegalName $e){
            $this->assertTrue(false,"新的文件名存在非法字符串");
        }
        catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }
}