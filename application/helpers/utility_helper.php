<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-7-24下午06:16:58
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//获取在线IP
function getonlineip($format=0) {

	if(isset($_SERVER['HTTP_CDN_SRC_IP']) && $_SERVER['HTTP_CDN_SRC_IP'] && strcasecmp($_SERVER['HTTP_CDN_SRC_IP'], 'unknown')){
		$onlineip = $_SERVER['HTTP_CDN_SRC_IP'];
	} elseif(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$onlineip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
	$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';

	if($format) {
		$ips = explode('.', $onlineip);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $onlineip;
	}
}

function newhtmlspecialchars($string) {
	if(is_array($string)){
		return array_map('newhtmlspecialchars', $string);
	} else {
//		$string = htmlspecialchars($string, ENT_QUOTES);
		$string = htmlspecialchars($string);
		$string = sstripslashes($string);
		$string = saddslashes($string);
		return trim($string);
	}
}

//去掉slassh
function sstripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = sstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

function isemail($email) {
	return strlen ( $email ) > 8 && preg_match ( "/^[-_+.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+([a-z]{2,4})|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email );
}

function isusername($string){
	//只允许汉字，大小写字母，数字作为用户名
	return preg_match("/^[\x{4e00}-\x{9fa5}|a-z|A-Z|0-9]+$/u", $string);
}

function is_url($url){
	return preg_match('/http:\/\/([a-zA-Z0-9-]*\.)+[a-zA-Z]{2,3}/', $url);
}

function is_ip($ip){ 
	if(!strcmp(long2ip(sprintf('%u',ip2long($ip))),$ip)) {
		return true;
	}
	return false;
}

//计算字符串长度,1个中文字符长度为1，1个英文字符串长度为0.5
function cnstrlen($str) {
	$i = 0;
	$count = 0;
	$len = strlen ($str);
	while ($i < $len) {
		$chr = ord ($str[$i]);
		if($chr > 127){
			$count++;
		} else {
			$count+=0.5;
		}
		$i++;
		if($i >= $len) break;
		if($chr & 0x80) {
			$chr <<= 1;
			while ($chr & 0x80) {
				$i++;
				$chr <<= 1;
			}
		}
	}
	return $count;
}



//取消HTML代码
function shtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = shtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
			str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}

function display(){
	$CI =& get_instance();
    $CI->tpl->display(get_tpl_resource_name());
}

function get_tpl_resource_name(){
    //加载请求路由处理类,获取控制器名称,方法名称
	$RTR =& load_class('Router');
	$class  = $RTR->fetch_class();
	$method = $RTR->fetch_method();
	$CI =& get_instance();
	$CI->tpl->set_tpl_dir($class);

	$resource_name = $method.SMARTY_SUFFIX_NAME;
	return $resource_name;
}

function tpl_fetch($folder, $resource_name){
	tplinit();

	$CI =& get_instance();
	$CI->tpl->set_tpl_dir($folder);
    return $CI->tpl->fetch($resource_name.SMARTY_SUFFIX_NAME);
}

function tplinit(){
	$RTR =& load_class('Router');
	$class  = strtolower($RTR->fetch_class());
	$method = strtolower($RTR->fetch_method());
	$CI =& get_instance();

	$vars = array(
		// 'uid'=>$CI->user->uid,
		'uid'=>$_SESSION['uid'],
		'member'=>$CI->user->member,
		'timestamp'=>SITE_TIME,
		'sessionid'=>SESSIONID,
		'siteurl'=>SITE_URL,
		'imgdir'=>$CI->config->item('imgdir'),
		'cssdir'=>$CI->config->item('cssdir'),
		'jsdir'=>$CI->config->item('jsdir'),
		'imgpath'=>$CI->config->item('imgpath'),
		'respath'=>$CI->config->item('respath'),
		'site_name'=>$CI->config->item('site_name'),
		'site_title'=>($class == 'index')?$CI->config->item('site_title'):'',
		'site_keywords'=>$CI->config->item('site_keywords'),
		'site_description'=>$CI->config->item('site_description'),
		'siteclass'=>$class,
		'sitemethod'=>$method,
		'inajax'=>INAJAX,
		'toyear'=>date('Y')
	);
	$CI->tpl->assign($vars);
}

function set_page_title($title){
	tpl_assign('pagetitle', $title);
}

function set_module_title($title){
	tpl_assign('moduletitle', $title);
}

function set_meta_keywords($keywords){
	tpl_assign('meta_keywords', $keywords);
}

function set_meta_description($description){
	tpl_assign('meta_description', $description);
}

function tpl_assign($name, $value){
	$CI =& get_instance();
	$CI->tpl->assign($name, $value);
}



//判断提交是否正确
function submitcheck($var) {
	if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) && $_POST['formhash'] == formhash()) {
			return TRUE;
		} else {
			showmessage('您的请求来路不正确或表单验证串不符，无法提交。请尝试使用标准的web浏览器进行操作。', 0);
		}
	} else {
		return FALSE;
	}
}

function formhash() {

	$CI =& get_instance();
	$hashadd = defined('IN_ADMINCP') ? 'Only For JiaThis AdminCP' : '';
	$formhash = substr(md5(substr(SITE_TIME, 0, -7).'|'.$CI->user->uid.'|'.md5($CI->config->item('site_key')).'|'.$hashadd), 8, 8);
	return $formhash;
}

//检查会员是否登录
function checklogin($redirect_url = '') {
	if(!islogin()) {

		if(!empty($redirect_url)){
			$redirect_url = $redirect_url;
		} else {

			$redirect_url = SCRIPT_URL;

			if(INAJAX){
				if(!empty($_SERVER['HTTP_REFERER'])){
					$redirect_url = $_SERVER['HTTP_REFERER'];
				}
			}
		}
		showmessage('你需要登录后才能进行本次操作。',SITE_URL.'/login/?redirect_url='.urlencode($redirect_url), 0);
	}
}


//判断字符串是否存在
function strexists($haystack, $needle) {
	return !(stripos($haystack, $needle) === FALSE);
}

//判断一个字符串在另一段字符中是否存在
//判断源字串的长度，然后用需要查找的字串去替换源字串，然后判断长度，长度改变即表示存在

function strisin($str,$string){
    $a = strlen($string);

    $l = strlen(str_ireplace($str, "", $string));

    if($l < $a){
    	return TRUE;
    } else {
    	return FALSE;
    }
}

function islogin(){
	// $CI =& get_instance();
	// return $CI->user->uid > 0 ? TRUE : FALSE;
	return isset($_SESSION["uid"]) ? TRUE : FALSE;
}

//获取表名
function tname($tablename, $databasename = DB_UYAN) {
	$db_prefix = constant('DB_'.strtoupper($databasename).'_PREFIX');
	$databasename = $databasename == DB_UYAN ? '' : $databasename.'.';
	return $databasename.$db_prefix.$tablename;
}


//添加数据
function inserttable($tablename, $insertsqlarr, $returnid = 0, $replace = false) {
	$CI =& get_instance();

	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$query = $CI->db->query($method.' INTO '.tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')');
	if($returnid && !$replace) {
		return $CI->db->insert_id();
	}
	return $query;
}


//更新数据
function updatetable($tablename, $setsqlarr, $wheresqlarr) {
	$CI =& get_instance();

	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	return $CI->db->query('UPDATE '.tname($tablename).' SET '.$setsql.' WHERE '.$where);
}


function ajax_header() {
	@header("Expires: -1");
	@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
	@header("Pragma: no-cache");
}

function cache_header($cachetime = 21600) {
	@header("Pragma: public");
	@header("Cache-Control: max-age=$cachetime");
	@header("Expires: ".gmdate("D, d M Y H:i:s", time() + $cachetime)." GMT");
}

/**
* 执行sql语句，只得到一条记录
*/
function GetRow($sql, &$db = null){
	if(!$db){
		$CI =& get_instance();
		$db = $CI->db;
	}
	$query = $db->query($sql.' LIMIT 1');
	if($query){
	    return $query->row_array();
	}
    return FALSE;
}

/**
* 取得一个某个字段的值
*/
function GetOne($sql, &$db = null){
	if($row = GetRow($sql, $db)){
		$row = array_values($row);
		return $row[0];
	}
    return FALSE;
}

//获取文件后缀名
function fileext($filename) {
	return trim(substr(strrchr($filename, '.'), 1, 10));
}

//utf-8转unicode
function utf8_to_unicode($str) {
	$unicode = array();
	$values = array();
	$lookingFor = 1;
	for ($i = 0; $i < strlen( $str ); $i++ ) {
		$thisValue = ord( $str[ $i ] );

        if ( $thisValue < ord('A') ) {
            // exclude 0-9
            if ($thisValue >= ord('0') && $thisValue <= ord('9')) {
                 // number
                 $unicode[] = chr($thisValue);
            } else {
                 $unicode[] = '\\'.dechex($thisValue);
            }
        } else {

        	if ( $thisValue < 128) {
        		$unicode[] = $str[ $i ];
        	} else {
                    if(count( $values ) == 0) {
                    $lookingFor = ( $thisValue < 224 ) ? 2 : 3;
                    }

                    $values[] = $thisValue;

                    if ( count( $values ) == $lookingFor ) {
                    $number = ( $lookingFor == 3 ) ?
                            ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                            ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );

                        $number = dechex($number);
                        $unicode[] = (strlen($number)==3)?"\u0".$number:"\u".$number;
                        $values = array();
                        $lookingFor = 1;
              	}
            }
        }
	}
	return implode("",$unicode);
}


//获取字符串
function getstr($string, $length, $in_slashes=0, $out_slashes=0, $html=0) {

	$string = trim($string);

	if($in_slashes) {
		//传入的字符有slashes
		$string = sstripslashes($string);
	}
	if($html < 0) {
		//去掉html标签
		$string = preg_replace("/(\<[^\<]*\>|\r|\n|\s|\[.+?\])/is", ' ', $string);
		$string = shtmlspecialchars($string);
	} elseif ($html == 0) {
		//转换html标签
		$string = shtmlspecialchars($string);
	}

	if($length && strlen($string) > $length) {
		//截断字符
		$wordscut = '';
		$CI =& get_instance();
		if(strtolower($CI->config->item('charset')) == 'utf-8') {
			//utf8编码
			$n = 0;
			$tn = 0;
			$noc = 0;
			while ($n < strlen($string)) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1;
					$n++;
					$noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2;
					$n += 2;
					$noc += 2;
				} elseif(224 <= $t && $t < 239) {
					$tn = 3;
					$n += 3;
					$noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4;
					$n += 4;
					$noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5;
					$n += 5;
					$noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6;
					$n += 6;
					$noc += 2;
				} else {
					$n++;
				}
				if ($noc >= $length) {
					break;
				}
			}
			if ($noc > $length) {
				$n -= $tn;
			}
			$wordscut = substr($string, 0, $n);
		} else {
			for($i = 0; $i < $length - 1; $i++) {
				if(ord($string[$i]) > 127) {
					$wordscut .= $string[$i].$string[$i + 1];
					$i++;
				} else {
					$wordscut .= $string[$i];
				}
			}
		}
		$string = $wordscut;
	}

	if($out_slashes) {
		$string = saddslashes($string);
	}
	return trim($string);
}

function cutstr($string, $length, $dot = ' ...') {

	$CI =& get_instance();
	
	if(strlen($string) <= $length) {
		return $string;
	}

	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

	$strcut = '';
	if(strtolower($CI->config->item('charset')) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	return $strcut.$dot;
}

//SQL ADDSLASHES
function saddslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = saddslashes($val);
		}
	} else {
		$string = addslashes($string);
	}
	return $string;
}


//时间格式化
function sgmdate($dateformat, $timestamp='', $format=0) {

	$CI =& get_instance();

	if(empty($timestamp)) {
		$timestamp = TIME_STAMP;
	}

	$timeoffset = intval($CI->config->item('timeoffset'));
	$result = '';
	if($format) {
		$time = TIME_STAMP - $timestamp;

		if($time > 24*3600) {
			$result = gmdate($dateformat, $timestamp + $timeoffset * 3600);
		} elseif ($time > 3600) {
			$result = intval($time/3600).'小时前';
		} elseif ($time > 60) {
			$result = intval($time/60).'分钟前';
		} elseif ($time > 0) {
			$result = $time.'秒前';
		} else {
			$result = '现在';
		}
	} else {
		$result = gmdate($dateformat, $timestamp + $timeoffset * 3600);
	}
	return $result;
}

//字符串时间化
function sstrtotime($string) {
	$CI =& get_instance();
	$time = '';
	if($string) {
		$time = strtotime($string);
		if(gmdate('H:i', TIME_STAMP + $CI->config->item('timeoffset') * 3600) != date('H:i', TIME_STAMP)) {
			$time = $time - $CI->config->item('timeoffset') * 3600;
		}
	}
	return $time;
}


function hex2bin($hexdata) {
	$bindata = '';
	for ($i = 0; $i < strlen($hexdata); $i += 2) {
		$bindata .= chr(hexdec(substr($hexdata,$i,2)));
	}
	return $bindata;
}

/**
 * @desc 全角字符与成半角字符的相互转换
 * @param $string
 * @param $flag 0=全角到半角,1=半角到全角
 */
function sbc2dbc($string, $flag = 0) {
	//全角
	$SBC = array(
		'０' , '１' , '２' , '３' , '４' ,

		'５' , '６' , '７' , '８' , '９' ,

		'Ａ' , 'Ｂ' , 'Ｃ' , 'Ｄ' , 'Ｅ' ,

		'Ｆ' , 'Ｇ' , 'Ｈ' , 'Ｉ' , 'Ｊ' ,

		'Ｋ' , 'Ｌ' , 'Ｍ' , 'Ｎ' , 'Ｏ' ,

		'Ｐ' , 'Ｑ' , 'Ｒ' , 'Ｓ' , 'Ｔ' ,

		'Ｕ' , 'Ｖ' , 'Ｗ' , 'Ｘ' , 'Ｙ' ,

		'Ｚ' , 'ａ' , 'ｂ' , 'ｃ' , 'ｄ' ,

		'ｅ' , 'ｆ' , 'ｇ' , 'ｈ' , 'ｉ' ,

		'ｊ' , 'ｋ' , 'ｌ' , 'ｍ' , 'ｎ' ,

		'ｏ' , 'ｐ' , 'ｑ' , 'ｒ' , 'ｓ' ,

		'ｔ' , 'ｕ' , 'ｖ' , 'ｗ' , 'ｘ' ,

		'ｙ' , 'ｚ' , '－' , '　'  , '：' ,

		'．' , '，' , '／' , '％' , '＃' ,

		'！' , '＠' , '＆' , '（' , '）' ,

		'＜' , '＞' , '＂' , '＇' , '？' ,

		'［' , '］' , '｛' , '｝' , '＼' ,

		'｜' , '＋' , '＝' , '＿' , '＾' ,

		'￥' , '￣' , '｀'

	);
	//半角
	$DBC = array(
		 '0', '1', '2', '3', '4',

		 '5', '6', '7', '8', '9',

		 'A', 'B', 'C', 'D', 'E',

		 'F', 'G', 'H', 'I', 'J',

		 'K', 'L', 'M', 'N', 'O',

		 'P', 'Q', 'R', 'S', 'T',

		 'U', 'V', 'W', 'X', 'Y',

		 'Z', 'a', 'b', 'c', 'd',

		 'e', 'f', 'g', 'h', 'i',

		 'j', 'k', 'l', 'm', 'n',

		 'o', 'p', 'q', 'r', 's',

		 't', 'u', 'v', 'w', 'x',

		 'y', 'z', '-', ' ', ':',

		'.', ',', '/', '%', '#',

		'!', '@', '&', '(', ')',

		'<', '>', '"', '\'','?',

		'[', ']', '{', '}', '\\',

		'|', '+', '=', '_', '^',

		'￥', '~', '`'
	);

	//半角到全角
	if($flag == 1) {
		return str_replace($DBC, $SBC, $string);
	}
	//全角到半角
	else {
		return str_replace($SBC, $DBC, $string);
	}
}

//密码加密算法
function password_encrypt($password, $salt){
	$passwordmd5 = md5($password);
	return md5($passwordmd5.$salt);
}
//生成密码盐
function password_salt(){
	$salt = substr(uniqid(rand()), -6);
	return $salt;
}


//Ajax信息格式化输出
function ajax_output($message, $success = 0){

	if(!is_array($message)){
		$message = array('message' => $message);
	}
	$message['success'] = $success;
	$message['message'] = sstripslashes($message['message']);
	exit(json_encode($message));
}


function convToUtf8($str, $encodearr=array('CP936','UTF-8')) {
	$encode = mb_detect_encoding($str, array('ASCII','GB2312','GBK','UTF-8'));
	if(!in_array($encode, $encodearr)) {
		return mb_convert_encoding($str, 'UTF-8', $encode);
	} else{
		return $str;
	}
}


function jfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 1, $block = TRUE) {
	
	//$post参数实例：$post = sprintf('action=%s&url=%s', 's', rawurlencode($url));
	
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;

	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(!$status['timed_out']) {
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}


function sendmail($toemail, $subject, $message, $from = '', $mailusername = 1, $maildelimiter = "\n"){
	$CI =& get_instance();
	$charset = strtolower($CI->config->item('charset'));
	
	$email_from = $from == '' ? '=?'.$charset.'?B?'.base64_encode('友言')."?= <noreply@uyan.cc>" : (preg_match('/^(.+?) \<(.+?)\>$/',$from, $mats) ? '=?'.$charset.'?B?'.base64_encode($mats[1])."?= <$mats[2]>" : $from);
	$email_to = preg_match('/^(.+?) \<(.+?)\>$/',$toemail, $mats) ? ($mailusername ? '=?'.$charset.'?B?'.base64_encode($mats[1])."?= <$mats[2]>" : $mats[2]) : $toemail;
	
	$email_subject = '=?'.$charset.'?B?'.base64_encode(preg_replace("/[\r|\n]/", '', $subject)).'?=';
	$email_message = chunk_split(base64_encode(str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $message))))));

	$host = empty($_SERVER['HTTP_HOST'])?'':$_SERVER['HTTP_HOST'];
	
	$headers = "From: $email_from{$maildelimiter}";
	$headers .= "X-Priority: 3{$maildelimiter}";
	$headers .= "X-Mailer: $host {$maildelimiter}";
	$headers .= "MIME-Version: 1.0{$maildelimiter}";
	$headers .= "Content-type: text/html; charset=".$charset."{$maildelimiter}";
	$headers .= "Content-Transfer-Encoding: base64{$maildelimiter}";
	
	$result = @mail($email_to, $email_subject, $email_message, $headers);	
	return $result;
}

function phpAlert($message, $url='') {
	echo '<script type="text/javascript">alert("'.$message.'");</script>';
	if(!empty($url)) echo '<script type="text/javascript">window.location.href="'.$url.'";</script>';
	exit;
}
function hideLocation($url, $message = '') {
	if ($message != '') echo '<script type="text/javascript">alert("'.$message.'");</script>';
	echo '<script type="text/javascript">parent.window.location="'.$url.'";</script>';
	exit;
}

function cache_read($action, $mode = 'i'){
	$cachefile = CACHE_DATA.'/data_'.$action.'.php';
	if(!file_exists($cachefile)) return array();
	return $mode == 'i' ? include $cachefile : @file_get_contents($cachefile);
}

function cache_update($action = ''){
	$CI =& get_instance();
	$data = array();
	switch($action){
		case 'cms_category';
			$query = $CI->db->query("SELECT * FROM ".tname('cms_category')." WHERE 1 ORDER BY cid ASC");
			if($query){
				foreach ($query->result_array() as $row){
					$data[] = $row;
				}
			}
		break;
		
		case 'cms_directory';
			$category = cache_read('cms_category');
			if(!$category){
				$category = cache_update('cms_category');
			}
			
			//获取全部的一级分类
			$topcate = array();
			foreach ($category as $val){
				if($val['parentid'] == 0){
					$topcate[] = $val;
				}
			}
			
			$CI->load->model('Cms_model', 'cmsmod');
			
			foreach ($topcate as $row){
				$orderaddtime = "DESC";
				//帮助分类的目录缓存按照 发布时间越早排序越靠前 的规则生成缓存
				if($row['cid'] == 1){
					$orderaddtime = "ASC";
				}
				$row['child'] = $CI->cmsmod->get_child_by_cid($row['cid'], $orderaddtime);
				$row['cms'] = $CI->cmsmod->get_cms_by_cid($row['cid']);
				$data[] = $row;
			}
		break;
		
		default:
			$actions = array('cms_category', 'cms_directory');
			array_map('cache_update', $actions);
			return true;
	}
	cache_write('data_'.$action.'.php', $data);
	return $data;
}

function cache_write($file, $string, $type = 'array'){
	if(is_array($string)){
		if($type == 'array'){
			$string = "<?php\r\n".
				"if ( ! defined('BASEPATH')) exit('No direct script access allowed');\r\n".
				"return ".arrayeval($string).
				";\r\n?>";
		}elseif($type == 'constant'){
			$data = '';
			foreach($string as $key => $value) {
				$data .= "define('".strtoupper($key)."','".addslashes($value)."');\n";
			}
			$string = "<?php\r\n".$data."\r\n?>";
		}
	}
	if(!is_dir(CACHE_DATA)) {
		mkdir(CACHE_DATA, 0777, true);
	}
	$strlen = @file_put_contents(CACHE_DATA.'/'.$file, $string);
	chmod(CACHE_DATA.'/'.$file, 0777);
	return $strlen;
}

function cache_delete($action){
	return @unlink(CACHE_DATA.'/data_'.$action.'.php');
}

//数组转换成字串
function arrayeval($array, $level = 0) {
	$space = '';
	for($i = 0; $i <= $level; $i++) {
		$space .= "\t";
	}
	$evaluate = "Array\n$space(\n";
	$comma = $space;
	foreach($array as $key => $val) {
		$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		if(is_array($val)) {
			$evaluate .= "$comma$key => ".arrayeval($val, $level + 1);
		} else {
			$evaluate .= "$comma$key => $val";
		}
		$comma = ",\n$space";
	}
	$evaluate .= "\n$space)";
	return $evaluate;
}

//二维数组排序
//示例：$services = array_msort($services, array('total_shares'=>SORT_DESC));
//$rekey(0 or 1) 返回结果是否需要重新索引数组下标
function array_msort($array, $cols, $rekey = 0){
	//http://cn.php.net/array_multisort
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
    	$i = 0;
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            $key = $rekey ? $i++ : $k;
            if (!isset($ret[$key])) $ret[$key] = $array[$k];
            $ret[$key][$col] = $array[$k][$col];
        }
    }
    return $ret;
}
function is_webid($webid) {
	$pattern = "/^[a-z\d]{1,32}$/i";
	return str_match($pattern, $webid);
}

function is_seourl($seourl) {
	$pattern = "/^[a-z\d\-\_]{1,100}$/i";
	return str_match($pattern, $seourl);
}

function str_match($pattern, $str){
	if(!empty($str)){
		if(preg_match($pattern, $str)) {
			return TRUE;
		}
	}
	return FALSE;
}

function is_sql_in_tables($sql, $tables, $database=DB_JIATHIS){
	$result = FALSE;
	$pattern = '/.*(from|update|into)[\s|\r\n|\n|\t]+(.*?)[\s|\r\n|\n|\t]/is';
 	preg_match($pattern, $sql, $sqls);
	if(!empty($sqls[2])){
		$table = $sqls[2];
		if(strexists($table, '.')){
			$table = str_ireplace($database.'.', '', $table);
		}
		if(in_array($table, $tables)){
			$result = TRUE;
		}
	}
	return $result;
}