<?php

require_once(APPPATH.'/inc/sina_config.php');
require_once(APPPATH.'/inc/renren_config.php');
require_once(APPPATH.'/inc/kaixin_config.php');
require_once(APPPATH.'/inc/sohu_config.php');
require_once(APPPATH.'/inc/neteasy_config.php');
require_once(APPPATH.'/inc/tencent_config.php');
require_once(APPPATH.'/inc/qq_config.php');
require_once(APPPATH.'inc/msn_config.php');


require_once(APPPATH."sdk/weibooauth.php");
require_once(APPPATH."sdk/RESTClient.class.php");
require_once(APPPATH."sdk/RenRenOauth.class.php");
require_once(APPPATH."sdk/RenRenClient.class.php");
require_once(APPPATH.'sdk/kaixin/kxclient.php');
require_once(APPPATH.'sdk/sohu/SohuOAuth.php');
require_once(APPPATH.'sdk/neteasy/tblog.class.php');

require_once(APPPATH.'sdk/qq/oauth/redirect_to_login.php');

require_once(APPPATH.'sdk/tencent/api_client.php');
require_once(APPPATH.'sdk/tencent/opent.php');

require_once(APPPATH.'sdk/msn/msn_sdk.php');


$platform = array(
  'youyan' => '友言',
  'sina' => '新浪微博',
  'renren' => '人人网',
  'tencent' => '腾讯微博',
  'qq' => 'QQ空间',
  'douban' => '豆瓣',
  'neteasy' => '网易微博',
  'sohu' => '搜狐微博', 
  'kaixin' => '开心网',
  'msn' => 'MSN'
);


$ENTRANCE = array(
  'sohu' => 'http://t.sohu.com/people?uid=',
  'sina' => 'http://weibo.com/',
  'tencent' => 'http://t.qq.com/',
  'renren' => 'http://www.renren.com/profile.do?id=',
  'neteasy' => '',
  'kaixin' => 'http://www.kaixin001.com/home/?uid='
);



