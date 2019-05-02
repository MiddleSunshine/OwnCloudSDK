<?php
/**
 * File name: FileShareTest.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-02
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\test;

use OwnCloudeSDK\Exception\alreadyShared;
use OwnCloudeSDK\Exception\FolderNotExist;
use OwnCloudeSDK\Operate\FileShare;
use OwnCloudeSDK\Operate\Folder;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Operate/Folder.php";
require_once __DIR__."/../Operate/FileShare.php";


class FileShareTest extends Base
{
    private $shareFolder="/ShareTest";
    public function setUp(): void
    {
        // 先创建分享的目录
        $config=$this->getConfigData();
        $folder=new Folder(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        try{
            $folder->createFolder($this->shareFolder);
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }
    public function testFileShare(){
        $config=$this->getConfigData();
        $fileShare=new FileShare(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        // 设置分享权限
        $fileShare->setFileSharePermission(FileShare::READ_PERMISSION);
        $fileShare->setFileSharePermission(FileShare::SHARE_PERMISSION);
        try{
            $shareUserId=$config['another_user_name'];
            $shareType=FileShare::SHARE_USER;
            $shareUrl=$fileShare->createFileShare($this->shareFolder,$shareUserId,$shareType);
            if($shareUrl && $shareType==FileShare::SHARE_PUBLIC){
                print "\r\n分享的url为:{$shareUrl}\r\n";
            }
            $this->assertTrue(true);
        }catch (alreadyShared $e){
            $this->assertTrue(false,"当前分享对象已拥有该目录权限");
        }catch (FolderNotExist $e){
            $this->assertTrue(false,"指定目录/文件夹不存在");
        }
        catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }
    public function testCreateFileShareWithPassword(){
        $config=$this->getConfigData();
        $fileShare=new FileShare(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        $password="phpunit";
        try{
            $shareUrl=$fileShare->createFileShareWithPassword($this->shareFolder,$password,FileShare::getExpireDate("2019","06","01"));
            print "\r\n创建分享,地址为：";
            print $shareUrl."\r\n";
            print "密码为：";
            print $password."\r\n";
            $this->assertTrue(true);
        }catch (alreadyShared $e){
            $this->assertTrue(false,"当前分享对象已拥有该目录权限");
        }catch (FolderNotExist $e){
            $this->assertTrue(false,"指定目录/文件夹不存在");
        }
        catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }


    }
    protected function tearDown(): void
    {
        // 删除创建的分享目录
        $config=$this->getConfigData();
        $folder=new Folder(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        try{
            $folder->deleteFolder($this->shareFolder);
        }catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }
}