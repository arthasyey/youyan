<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
return Array
	(
	0 => Array
		(
		'cid' => 1,
		'parentid' => 0,
		'action' => 'help',
		'typename' => '帮助',
		'sortrank' => 50
		),
	1 => Array
		(
		'cid' => 2,
		'parentid' => 1,
		'action' => 'faq',
		'typename' => '常见问题',
		'sortrank' => 1
		),
	2 => Array
		(
		'cid' => 3,
		'parentid' => 1,
		'action' => 'install',
		'typename' => '安装',
		'sortrank' => 2
		),
	3 => Array
		(
		'cid' => 4,
		'parentid' => 1,
		'action' => 'setting',
		'typename' => '设置',
		'sortrank' => 3
		),
	4 => Array
		(
		'cid' => 5,
		'parentid' => 1,
		'action' => 'manage',
		'typename' => '管理',
		'sortrank' => 4
		),
	5 => Array
		(
		'cid' => 6,
		'parentid' => 0,
		'action' => 'getcode',
		'typename' => '获取代码',
		'sortrank' => 50
		),
	6 => Array
		(
		'cid' => 7,
		'parentid' => 6,
		'action' => 'wordpress',
		'typename' => 'Wordpress说明',
		'sortrank' => 50
		)
	);
?>