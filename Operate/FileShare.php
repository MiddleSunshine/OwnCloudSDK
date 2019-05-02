<?php
/**
 * File name: FileShare.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-02
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Operate;

use OwnCloudeSDK\Connection\PostOperate;
use OwnCloudeSDK\Exception\alreadyShared;
use OwnCloudeSDK\Exception\FolderNotExist;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Connection/PostOperate.php";
require_once __DIR__."/../Exceptions/alreadyShared.php";
require_once __DIR__."/../Exceptions/FolderNotExist.php";

class FileShare extends Base
{
    const API="/ocs/v2.php/apps/files_sharing/api/v1/shares?format=json";
    /*
     * 权限相关配置
     */
    const READ_PERMISSION=1;// 读权限
    const UPDATE_PERMISSION=2;// 更新权限
    const CREATE_PERMISSION=4;// 创建权限
    const DELETE_PERMISSION=8;// 删除权限
    const SHARE_PERMISSION=16;// 分享权限
    const ALL_PERMISSION=31;// 所有权限

    protected $permissions=0;// 记录用户设置的权限
    protected $settedPermission=array();// 记录用户设置过的权限，防止重复设置
    /*
     * 分享类型设置
     */
    const SHARE_USER='USER';
    const SHARE_GROUP='GROUP';
    const SHARE_PUBLIC='PUBLIC';
    const SHARE_UNIT_CLOUD='UNIQUE_CLOUD';

    protected $allShareType=array();

    /**
     * 设置分享权限
     * @param $permissionType
     * @throws \Exception
     */
    public function setFileSharePermission($permissionType=self::READ_PERMISSION){
        // 不允许设置无效值
        $userfulPermission=array(
            self::READ_PERMISSION,
            self::UPDATE_PERMISSION,
            self::CREATE_PERMISSION,
            self::DELETE_PERMISSION,
            self::SHARE_PERMISSION,
            self::ALL_PERMISSION
        );
        if(!in_array($permissionType,$userfulPermission)){
            throw new \Exception($permissionType."不是有效权限");
        }
        // 如果设置了所有权限，则将权限设置为 31
        if($permissionType>=self::ALL_PERMISSION){
            $this->permissions=self::ALL_PERMISSION;
            return;
        }
        // 不允许重复设置
        if(isset($this->settedPermission[$permissionType])){
            throw new \Exception("重复设置相同权限");
        }
        $this->permissions+=$permissionType;
        $this->settedPermission[$permissionType]=1;
    }

    /**
     * 创建文件/文件夹的分享
     * @param $shareFilePath string 待分享的文件，文件夹目录
     * @param $shareUserId string 分享的用户id，组id，
     * @param string $shareType 分享类型
     * @return null | string
     * @throws FolderNotExist
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws alreadyShared
     */
    public function createFileShare($shareFilePath,$shareUserId,$shareType=self::SHARE_USER){
        if(is_array($shareUserId)){
            throw new \Exception("不支持多用户分享");
        }
        // 设置有效分享类型
        $this->setShareTypeData();
        if(!array_key_exists($shareType,$this->allShareType)){
            throw new \Exception("分享类型错误");
        }
        // 设置权限
        $this->permissions==0 && $this->permissions=self::READ_PERMISSION;// 如果用户没有设置权限，则采用最小权限
        $post=new PostOperate($this->userName,$this->password);
        $postData=array(
            'shareType'=>$this->allShareType[$shareType],
            'shareWith'=>$shareUserId,
            'permissions'=>$this->permissions,
            'path'=>$shareFilePath
        );
        // 如果是公共链接，则不需要指定分享人，但是需要指定分享名称
        if($shareType==self::SHARE_PUBLIC){
            unset($postData['shareWith']);
            $postData['name']=date("Y-m-d");// 生成同样名字的分享名是不会出错的
        }
        $url=$this->domain.self::API;
        $result=$post->post($url,$postData,$this->isHttps);
        if(!$result['result']){
            // 针对 自己分享给自己 或者 分享给已经分享过的用户 均会报403错误，所以在这里设置排除异常类
            if(intval($result['data'])==403){
                throw new alreadyShared("当前用户已拥有该目录权限");
            }
            // 分享不存在的目录
            if(intval($result['data'])==404){
                throw new FolderNotExist("指定目录/文件夹不存在");
            }
            throw new \Exception($result['message']);
        }
        if($shareType==self::SHARE_PUBLIC){
            // 则返回对应的分享链接
            $shareUrl=$result['data']['ocs']['data']['url'];
            return $shareUrl;
        }else{
            // 返回空
            return null;
        }
    }
    public function createFileShareWithPassword(){

    }

    /**
     * 设置所有分享类型的数据
     */
    private function setShareTypeData(){
        $this->allShareType=array(
            self::SHARE_USER=>0,
            self::SHARE_GROUP=>1,
            self::SHARE_PUBLIC=>3,
            self::SHARE_UNIT_CLOUD=>6
        );
    }
}