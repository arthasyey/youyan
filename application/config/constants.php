<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| debug模式是否开启
|--------------------------------------------------------------------------
|
| 0: 关闭, 1: 开启
|
*/
define('OPEN_DEBUG', 0);

if(OPEN_DEBUG) {
    ini_set('display_errors', TRUE);
    error_reporting(E_ALL);
} else {
	error_reporting(0);
}

/*
|--------------------------------------------------------------------------
| 数据库DB开关
|--------------------------------------------------------------------------
|
| 0: 关闭, 1: 开启
| 当数据库服务器无法连接的时候将此值设为0
*/
define('DB_SWITCH', 1);

// MEMCACHE开关
define('MEM_STATUS', true);

/*
|--------------------------------------------------------------------------
| 网站根目录
|--------------------------------------------------------------------------
*/
define('SITE_ROOT', substr(str_replace('\\', '/', FCPATH), 0, -1));

/*
|--------------------------------------------------------------------------
| AJAX请求
|--------------------------------------------------------------------------
*/
define('INAJAX', isset($_GET['inajax'])?intval($_GET['inajax']):0);

/*
|--------------------------------------------------------------------------
| session id
|--------------------------------------------------------------------------
*/
define('SESSIONID', session_id());

/*
|--------------------------------------------------------------------------
| 时间处理
|--------------------------------------------------------------------------
*/
$mtime = explode(' ', microtime());
define('TIME_STAMP', $mtime[1]);
define('SUPE_STARTTIME', (TIME_STAMP + $mtime[0]));
define('SITE_TIME', TIME_STAMP);
define('SITE_DATETIME', date('Y-m-d H:i:s', TIME_STAMP));

/*
|--------------------------------------------------------------------------
| 网站相对目录
|--------------------------------------------------------------------------
*/
define('SITE_PATH', str_ireplace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']),'',SITE_ROOT));

/*
|--------------------------------------------------------------------------
| 站点URL
|--------------------------------------------------------------------------
*/
$PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
$PHP_SCHEME = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
$PHP_PORT = $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
define('SITE_URL', $PHP_SCHEME.$_SERVER['SERVER_NAME'].$PHP_PORT.SITE_PATH);
define('SCRIPT_URL', $PHP_SCHEME.$_SERVER['SERVER_NAME'].$PHP_PORT.$PHP_SELF.($_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : ''));
define('SITE_DOMAIN', $_SERVER['SERVER_NAME']);
define('REDIRECT_URL', isset($_GET['redirect_url']) ? urldecode($_GET['redirect_url']) : '');

/*
|--------------------------------------------------------------------------
| 时区设置
|--------------------------------------------------------------------------
*/
if(PHP_VERSION > '5.1') date_default_timezone_set('Etc/GMT-8');

/*
|--------------------------------------------------------------------------
| 程序缓存目录
|--------------------------------------------------------------------------
*/
define("CACHE_DATA", BASEPATH.'cache/data');

/*
|--------------------------------------------------------------------------
| 数据库配置
|--------------------------------------------------------------------------
*/
//数据库debug @todo:正式运行环境将此项设置为FALSE
define('DB_DEBUG', FALSE);

//数据库名
define('DB_UYAN', 'uyan');

//数据表前缀
define('DB_UYAN_PREFIX', 'uyan_');
/*
|--------------------------------------------------------------------------
| 定义一些相对于网站根目录的资源目录,后面结尾不加'/'
|--------------------------------------------------------------------------
*/
//总资源目录
define('PATH_RESOURCE', '/resource');
//字体文件目录
define('PATH_FONT', PATH_RESOURCE.'/fonts');
//站点图片目录
define('PATH_IMAGES', PATH_RESOURCE.'/images');


/*
|--------------------------------------------------------------------------
| 当前使用的风格名称
|--------------------------------------------------------------------------
*/
define('THEME', 'default');

/*
|--------------------------------------------------------------------------
| 定义图标'/'
|--------------------------------------------------------------------------
*/
define('ICON_OK', '<img align="absmiddle" src="'.PATH_IMAGES.'/message/ico_ok.gif" /> ');
define('ICON_ERROR', '<img align="absmiddle" src="'.PATH_IMAGES.'/message/ico_error.gif" /> ');

/*
|--------------------------------------------------------------------------
| 模板配置
|--------------------------------------------------------------------------
*/
//默认模板目录
define('SMARTY_TEMPLATES_DIR', SITE_ROOT . '/application/views');
//模板编译目录
define('SMARTY_COMPILE_DIR', BASEPATH . 'cache/templates_c');
//模板缓存目录
define('SMARTY_CACHE_DIR', BASEPATH . 'cache/cache');
//模板配置目录
define('SMARTY_CONFIG_DIR', SITE_ROOT . '/application/config');
//模板左分隔符
define('SMARTY_LEFT_DELIMITER', '<{');
//模板右分隔符
define('SMARTY_RIGHT_DELIMITER', '}>');
//模板调试开关
define('SMARTY_DEBUGGING', FALSE);
//模板强制编译开关,开发阶段为TRUE @todo:正式运行环境设置为FASLE
define('SMARTY_FORCE_COMPILE', TRUE);
//编译检查开关
define('SMARTY_COMPILE_CHECK', FALSE);
//模板缓存开关
define('SMARTY_CACHING', FALSE);
//模板文件扩展名
define('SMARTY_SUFFIX_NAME', '.html');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
