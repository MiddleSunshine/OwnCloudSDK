<?php
/**
 * File name: alreadyShared.php
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
 * 异常类，当针对一个已经分享过的文件夹/文件对同一个用户创建分享时，就会抛出该异常
 * Class alreadyShared
 * @package OwnCloudeSDK\Exception
 */
class alreadyShared extends \Exception
{

}