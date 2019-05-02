<?php
/**
 * File name: UploadFileTest.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-02
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\test;

use OwnCloudeSDK\Exception\UnlegalName;
use OwnCloudeSDK\Operate\UploadFile;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Operate/UploadFile.php";

class UploadFileTest extends Base
{
    private $uploadFile="";
    private $fileName="UploadFile.html";
    protected function setUp(): void
    {
        $this->uploadFile=__DIR__."/".$this->fileName;
    }

    public function testUpload(){
        $config=$this->getConfigData();
        $uploadFile=new UploadFile(
            $config['domain'],
            $config['user_name'],
            $config['password'],
            $config['is_https']
        );
        try{
            $uploadFile->upload("/",$this->uploadFile,$this->fileName);
            $this->assertTrue(true);
        }catch (UnlegalName $e){
            $this->assertTrue(false,"文件名中存在非法字符");
        }
        catch (\Exception $e){
            $this->assertTrue(false,$this->getException($e));
        }
    }
}