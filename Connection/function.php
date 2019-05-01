<?php
/**
 * File name: function.php
 * Author: 杨庆贤
 * Description:
 * Others:
 * History:
 *   Date: 2019-05-01
 *   Author:
 *   Modification
 */
function p($data){
    print "\r\n";
    print_r($data);
    print "\r\n";
    exit();
}

function humanData($byte){
    $byte=floatval($byte);
    $kb=round($byte/1024,1);
    if($kb>1){
        $m=round($kb/1024,1);
        if($m>1){
            $gb=round($m/1024,1);
            if($gb>1){
                return $gb." G";
            }else{
                return $m." M";
            }
        }else{
            return $kb." KB";
        }
    }else{
        return $byte." B";
    }
}