<?php
/* 获取Authorization Code
 * 每一个Authorization Code的有效期为一个小时，并且只能使用一次，再次使用将无效。
 *
 * 为了获取Authorization Code，应用需要将用户浏览器重定向到授权服务器“https://graph.renren.com/oauth/authorize”，并带上3个必须参数。
 *
 * client_id：必须参数。注册应用时获得的API Key。
 * response_type：必须参数。Web应用时，此值固定为“code”。
 * redirect_uri：授权后要回调的URI，即接受code的URI。 
 * scope：非必须参数。以空格分隔的权限列表，若不传递此参数，代表请求用户的默认权限。关于权限的具体信息请参考'权限列表'。
 * state：非必须参数。用于保持请求和回调的状态。授权服务器在回调时（重定向用户浏览器到“redirect_uri”时），会在Query Parameter中原样回传该参数。
 * display：非必须参数。登录和授权页面的展现实行，默认为“page”，适用于全功能浏览器的页面。此参数还可以设置为“mobile”，适用于WAP站点；“touch”适用于有全功能浏览器的智能手机客户端应用。
 */
require_once '../../requires.php';

$oauth = new RenRenOauth();

# 本例中是生成超链接，实际应用中您可以使用header("Location: $url");方式跳转
$url = $oauth->getAuthorizeUrl();
echo $url, '<br/><br/>';
?>
<a href="<?php echo $url; ?>">Authorize</a>