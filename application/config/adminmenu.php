<?php
/**
 * @copyright	© 2009-2011 JiaThis Inc.
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2011-3-30
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| 管理员导航菜单、权限
|--------------------------------------------------------------------------
*/

$ADMIN_MENU = array(
	'admincp' => array(
		'menu' => '首页',
		'isajax' => 0,
		'status' => 1,
		'method' => array(
			'index' => array(
				'menu' => '友言管理平台首页',
				'isajax' => 0,
				'status' => 1
			)
		)
	),
	'cmscp' => array(
		'menu' => '内容管理',
		'isajax' => 0,
		'status' => 1,
		'method' => array(
			'index' => array(
				'menu' => '内容管理',
				'isajax' => 0,
				'status' => 1
			),
			'add' => array(
				'menu' => '添加内容',
				'isajax' => 0,
				'status' => 1
			),
			'edit' => array(
				'menu' => '修改',
				'isajax' => 0,
				'status' => 0
			),
			'delete' => array(
				'menu' => '删除',
				'isajax' => 0,
				'status' => 0
			)
		)
	),
	'categorycp' => array(
		'menu' => '分类',
		'isajax' => 0,
		'status' => 1,
		'method' => array(
			'index' => array(
				'menu' => '分类管理',
				'isajax' => 0,
				'status' => 1
			),
			'add' => array(
				'menu' => '添加分类',
				'isajax' => 0,
				'status' => 1
			),
			'edit' => array(
				'menu' => '修改',
				'isajax' => 0,
				'status' => 0
			),
			'delete' => array(
				'menu' => '删除',
				'isajax' => 0,
				'status' => 0
			)
		)
	),
	'cachecp' => array(
		'menu' => '缓存',
		'isajax' => 0,
		'status' => 1,
		'method' => array(
			'index' => array(
				'menu' => '缓存管理',
				'isajax' => 0,
				'status' => 1
			),
			'cms_category' => array(
				'menu' => '内容分类',
				'isajax' => 0,
				'status' => 1
			),
			'cms_directory' => array(
				'menu' => '内容目录',
				'isajax' => 0,
				'status' => 1
			)
		)
	),
	'privilegescp' => array(
		'menu' => '权限',
		'isajax' => 0,
		'status' => 1,
		'method' => array(
			'adminlist' => array(
				'menu' => '管理员',
				'isajax' => 0,
				'status' => 1
			),
			'addadmin' => array(
				'menu' => '新增管理员',
				'isajax' => 0,
				'status' => 1
			),
			'edit' => array(
				'menu' => '修改权限',
				'isajax' => 0,
				'status' => 0
			),
			'editadmin' => array(
				'menu' => '修改资料',
				'isajax' => 0,
				'status' => 0
			)
		)
	),
	'adminsettingscp' => array(
		'menu' => '设置',
		'isajax' => 0,
		'status' => 1,
		'method' => array(
			'index' => array(
				'menu' => '基本设置',
				'isajax' => 0,
				'status' => 1
			),
			'password' => array(
				'menu' => '密码修改',
				'isajax' => 0,
				'status' => 1
			)
		)
	),
);