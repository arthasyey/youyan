<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.3
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */

require_once(APPPATH. "sdk/qq/comm/utils.php");

 /**
 * @brief 登录用户上传照片到QQ空间的某一个相册. 
 * 计算签名时参数名及其值不做URL编码，HTTP请求包的 body内容也不做URL编码
 *
 * @param $appid
 * @param $appkey
 * @param $access_token
 * @param $access_token_secret
 * @param $openid
 */
function upload_pic($appid, $appkey, $access_token, $access_token_secret, $openid)
{
	//上传照片的接口地址, 不要更改!!
    $url    = "http://openapi.qzone.qq.com/photo/upload_pic";
    echo do_multi_post($url, $appid, $appkey, $access_token, $access_token_secret, $openid);
}

?>
