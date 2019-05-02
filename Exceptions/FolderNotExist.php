<?php
/**
 * File name: FolderNotExist.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-02
 *   Author:
 *   Modification
 */

namespace OwnCloudeSDK\Exception;

/**
 * 在不存在的目录下操作时，比如创建文件夹，上传文件等，就会抛出该异常
 * Class FolderNotExist
 * @package OwnCloudeSDK\Exception
 */
class FolderNotExist extends \Exception
{

}