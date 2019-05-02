<?php
/**
 * File name: Base.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Operate;

class Base
{
    protected $domain;
    protected $userName;
    protected $password;
    protected $isHttps;

    /**
     * Base constructor.
     * @param $domain string 对应的域名
     * @param $userName string 当前操作用于的ownclound账号
     * @param $password string 当前人员的密码
     * @param $isHttps bool 该域名是否配置了CA证书
     */
    public function __construct($domain, $userName, $password, $isHttps)
    {
        $this->domain = $domain;
        $this->userName = $userName;
        $this->password = $password;
        $this->isHttps = $isHttps;
    }

    /**
     * 检查文件夹，文件名中是否有特殊字符串，如果有则视为异常
     * @param $fileName
     * @return bool
     */
    protected static function checkSpecialFileName($fileName)
    {
        if (strpos($fileName, "&")) {
            return false;
        }
        return true;
    }

    protected static function getUniqueName($fileName, $allFileName,$count=1)
    {
        $fileInfo=explode(".",$fileName);
        if(count($fileInfo)>1){
            // 拼接下一个文件名
            // 如果原来就是有（），这样记数的，则添加数字
            $preg="/\(\d{1,}\)/";
            if(preg_match($preg,$fileInfo[0])){
                // 先把右侧的括号删除掉
                $removeRightBracks=substr($fileInfo[0],0,strlen($fileInfo[0])-1);
                // 获取计数值
                $count=substr($removeRightBracks,strlen($removeRightBracks)-1,1);
                // 设置成下一个值
                $newCount=intval($count)+1;
                $fileFinalName=substr($removeRightBracks,0,strlen($removeRightBracks)-2);
                $handleFileName=$fileFinalName."({$newCount}).".$fileInfo[1];
            }else{
                $handleFileName=$fileInfo[0]."({$count}).".$fileInfo[1];
            }
        }else{
            // 该文件没有文件类型
            $handleFileName=$fileName."({$count})";
        }
        foreach ($allFileName as $value){
            if($handleFileName==$value['file_name']){
                $handleFileName=self::getUniqueName($handleFileName,$allFileName,$count+1);
                break;
            }
        }
        return $handleFileName;
    }
}