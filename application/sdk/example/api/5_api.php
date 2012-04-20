<?php
/**
 * 一个api的例子（获取当前登陆用户的前10位好友）
 *
 * friends.get
 * 
 * 将请求参数格式化为“key=value”格式，即“k1=v1”、“k2=v2”、“k3=v3”；
 * 将上诉格式化好的参数键值对，以字典序升序排列后，拼接在一起，即“k1=v1k2=v2k3=v3”；
 * 在上拼接好的字符串末尾追加上应用的Secret Key；
 * 上述字符串的MD5值即为签名的值。
 *
 * 注意：计算sig时的字符串，必须用UTF-8编码。
 * 注意：计算sig的时候不需要对参数进行URLEncode（“application/x-www-form-urlencoded”编码），但是发送请求的时候需要进行URLEncode。
 * 注意：有很多开发者在计算签名的时候，将参数名和参数值误使用“application/x-www-form-urlencoded”编码，导致签名验证失败。
 */
require_once '../../requires.php';

# api调用时实例化RenRenClient对象，oauth授权时实例化RenRenOauth对象。
$client = new RenRenClient();

# 如果您应该通过其他sdk（或自己实现）获得了session key，那么您可以选择只使用该sdk中的api部分
# 您可以通过setSessionKey方法设置您已经获取到的session key。
$session_key = $_GET['session_key'];
$client->setSessionKey($session_key);

# $client->setCallId('12345678');

# 调用api时的第一个参数是api方法名。
# 第二个参数请参考config.inc.php文件中的配置进行设置。
$friends = $client->POST('friends.getFriends', array('1', '10'));

foreach($friends as $friend) {
	echo "<img src=\"{$friend['tinyurl']}\" />&nbsp;&nbsp;{$friend['name']}<br/>";
}
?>