<?php
/**
 * File name: FilePath.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Operate;

use OwnCloudeSDK\Connection\GetOperate;
use OwnCloudeSDK\Connection\PropfindOperate;
use Sabre\Xml\ParseException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service;

require_once __DIR__."/Base.php";
require_once __DIR__."/../Connection/PropfindOperate.php";
require_once __DIR__."/../Connection/GetOperate.php";
require_once __DIR__."/File.php";
require_once __DIR__."/../vendor/autoload.php";

class FilePath extends Base
{
    const API="/remote.php/webdav";
    const SEARCH_API="/core/search";
    const XML_NAMESPACE="{DAV:}";

    /**
     * 获取指定目录下数据的文件列表
     * @param string $dir 指定目录
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFilePath($dir="/"){
        $searchDir=$this->domain.self::API.$dir;
        $propfind=new PropfindOperate($this->userName,$this->password);
        $result=$propfind->propfind($searchDir,$this->isHttps);
        if($result['result']){
            $xmlData=$this->xmlReader($result['data']);
            $fileList=$this->parseXml($xmlData);
            return $fileList;
        }else{
            throw new \Exception($result['message']);
        }
    }

//    /**
//     * TODO 该方法存在问题，暂时无法使用
//     * 搜索指定目录下内容，不支持全局搜索
//     * @param string $searchDir 搜索目录
//     * @param string $searchContent 搜索内容
//     * @param int $page 针对结果做分页效果
//     * @param int $size
//     * @return mixed
//     * @throws \GuzzleHttp\Exception\GuzzleException
//     */
//    public function search($searchDir="/",$searchContent="",$page=1,$size=10){
//        $queryFilePath='files'.$searchDir;
//        $url=$this->domain.self::SEARCH_API."?query=".$searchContent."&inApps[].".$queryFilePath."&page=".$page."&size=".$size;
//        $get=new GetOperate($this->userName,$this->password);
//        $result=$get->get($url,$this->isHttps);
//        if(!$result['result']){
//            throw new \Exception($result['message']);
//        }
//        return null;
//    }

    /**
     * 辅助函数，解析xml的字符串的
     * @param $xmlString
     * @return array|object|string
     */
    protected function xmlReader($xmlString){
        $service=new Service();
        $service->elementMap=[
            '{DAV:}response'=>function(Reader $reader){
                return \Sabre\Xml\Deserializer\keyValue($reader,'{DAV:}');
            },
            '{DAV:}multistatus'=>function(Reader $reader){
                return \Sabre\Xml\Deserializer\repeatingElements($reader,'{DAV:}response');
            },
            '{DAV:}propstat'=>"Sabre\Xml\Deserializer\keyValue",
            '{DAV:}prop'=>"Sabre\Xml\Deserializer\keyValue",
            '{DAV:}resourcetype'=>"Sabre\Xml\Deserializer\keyValue"
        ];
        try{
            return $service->parse($xmlString);
        }catch (ParseException $e){
            return "";
        }
    }

    /**
     * 辅助函数，提取xmlReader解析出来的xml数组中的有效值的
     * @param $xmlArray
     * @return array
     */
    protected function parseXml($xmlArray){
        if(count($xmlArray)<1){
            return [];
        }
        $returnData=[];
        $usefulArray=array_slice($xmlArray,1,count($xmlArray)-1);
        foreach ($usefulArray as $value){
            $file=new File();
            $temp=$value[self::XML_NAMESPACE."propstat"][self::XML_NAMESPACE."prop"];
            $fileTypeKey=self::XML_NAMESPACE."getcontenttype";
            if(array_key_exists($fileTypeKey,$temp)){
                // 当前数据为文件
                $file->isFolder=false;
                $file->fileType=$temp[$fileTypeKey];// 文件类型
                $file->usedBytes=$temp[self::XML_NAMESPACE."getcontentlength"];// 文件大小
            }else{
                // 当前数据为文件夹
                $file->fileType="Folder";// 文件类型为文件夹
                $file->usedBytes=$temp[self::XML_NAMESPACE."quota-used-bytes"];// 已使用大小
                $file->availableBytes=$temp[self::XML_NAMESPACE."quota-available-bytes"];// 剩余大小
            }
            $filePath=$value[self::XML_NAMESPACE."href"];
            $filePath_array=explode("/",$filePath);
            $fileName=end($filePath_array);
            if($fileName=='' && $file->fileType=="Folder"){
                $fileName=$filePath_array[(count($filePath_array)-2)];// 文件夹名
            }
            $file->fileName=urldecode($fileName);// 文件名
            $addTime=$value[self::XML_NAMESPACE."propstat"][self::XML_NAMESPACE."prop"][self::XML_NAMESPACE."getlastmodified"];
            $createTime=date("Y/m/d H:i",strtotime($addTime));// 文件/文件夹的创建时间
            // 文件的完整路径
            $fileFullPath=substr($value[self::XML_NAMESPACE."href"],18,strlen($value[self::XML_NAMESPACE."href"]));
            $file->filePath=urldecode($fileFullPath);// 文件完整路径
            $file->createTime=$createTime;
            // 将已使用大小和剩余大小做比较
            $file->usedBytes=humanData($file->usedBytes);
            $file->availableBytes=humanData($file->usedBytes);
            $returnData[]=$file->toArray();
        }
        return $returnData;
    }
}