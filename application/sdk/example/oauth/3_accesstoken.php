<?php
/**
 * 使用Authorization Code换取Access Token
 *
 * 默认情况下，Access Token的有效期为1天。
 *
 * 应用需要在接收Authorization Code 的服务端程序中发送请求（推荐post）到授权服务器“https://graph.renren.com/oauth/token”，并带上5个必须参数。
 * grant_type：使用Authorization Code 作为Access Grant时，此值为“authorization_code”。 
 * code：Authorization Code； 
 * client_id：应用的API Key； 
 * client_secret：应用的Secret Key； 
 * redirect_uri：必须与获取Authorization Code时传递的“redirect_uri”保持一致。
 */
require_once '../../requires.php';

$oauth = new RenRenOauth();
$code = $_GET['code'];

/**
 * 返回以下格式的数组
 *array(
 *	'access_token' => '130705|5.a2bf7f751cc195cbb310ff15e3cd793a.86400.1305525600-223378553',
 *	'expires_in' => 87048,
 *);
 */
$token = $oauth->getAccessToken($code);
var_dump($token);
echo '<br/><br/>';
?>
<a href="4_sessionkey.php?access_token=<?php echo $token['access_token']; ?>">Session Key</a>