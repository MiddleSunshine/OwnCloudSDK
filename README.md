# OwnCloudSDK
将owncloud的一些常见操作进行集成，也算是本人写的第一个开源项目。

其本质就是使用服务器模拟各种webdav的请求，来访问对应owncloud的服务器，实现获取文件夹列表，文件上传，移动等操作。

## 目录结构

- Connection：针对一些请求的封装
- Exception：针对一些异常种类的封装，根据业务需要，可以在异常抛出时，做对应的处理。
- Operate：核心操作类，也就是给用户调用的类。
- test：PHPUnit编写的一些测试类
- composer.json：所需要的拓展

## 使用教程

关于`Operate`核心类的使用教程，`test`目录中都有例子，但是在使用`test`中例子的时候，需要先配置好一些值：

打开`test/Base.php`中，将以下内容配置好：

```php
/**
     * 读取配置值
     * @return array
     */
    public function getConfigData(){
        return array(
            'domain'=>"",// owncloud的域名
            'user_name'=>"",// 对应的owncloud用户名
            'password'=>"",// 对应的owncloud的密码
            'is_https'=>true,// owncloud的域名是否使用了ca证书
            'another_user_name'=>""// 另一个owncloud的账号，主要是用于进行文件分享测试的
        );
    }
```

这里需要使用你们公司搭建的服务器配置，配置好之后，就可以跑`test`中的例子了。

## Operate中核心类介绍

- `Base.php`：基础类，封装一些公用方法
- `File.php`：文件类，记录文件的一些属性值
- `FilePath.php`：目录类，获取指定目录下的文件列表
- `FileShare.php`：文件分享类，可以创建针对文件，文件夹的分享地址，类似百度云的文件分享
- `Folder.php`：目录操作类，可以创建，移动，删除目录。
- `UploadFile.php`：文件上传类，用于上传文件到指定目录下