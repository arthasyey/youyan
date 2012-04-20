<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-9-25下午05:32:36
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorycp extends CI_Controller {
	
    public function __construct(){
    	parent::__construct();
    	ck_adminlogin();
    	set_module_title('内容分类管理');
    }

	public function index(){
		$addsuccess = isset($_GET['addsuccess']) ? intval($_GET['addsuccess']) : 0;
		$deletesuccess = isset($_GET['deletesuccess']) ? intval($_GET['deletesuccess']) : 0;
		
		$message = array();
		$msgtype = 'error';
		if(submitcheck('updatesortranksubmit')){
			$max_cid = GetOne("SELECT cid FROM ".tname('cms_category')." ORDER BY cid DESC");
			if($max_cid){
				for($i = 1; $i <= $max_cid; $i++){
					if(isset($_POST["sortrank{$i}"])){
						updatetable('cms_category', array('sortrank'=>intval($_POST["sortrank{$i}"])), array('cid'=>$i));
					}
				}
				$msgtype = 'ok';
				$message[] = '分类排序已经成功更新！';
			}
		}
		
		$this->load->library('category');
		$list = $this->category->getTopInfo();
		$vars = array(
			'addsuccess' => $addsuccess,
			'deletesuccess' => $deletesuccess,
			'list' => $list,
			'message' => $message,
			'msgtype' => $msgtype,
		);
		$this->tpl->assign($vars);
		$this->tpl->display();
	}
	
	public function getsuns($cid){
		ajax_header();
		if(empty($cid)) {
			echo '输出传输错误';
		} else {
			$this->load->library('category');
			$this->category->getAllSunList($cid);
		}
	}
	
	public function delete($cid){
		
		$cid = isset($cid) ? intval($cid) : 0;
		if(!$cid) showmessage('cid参数错误。', 0);
		
		if(submitcheck('deletesubmit')){
			$this->load->library('category');
			if($this->category->delTypeName($cid)){
				showmessage(ICON_OK.'该分类及其子分类已经被成功删除。', 0);
			} else {
				showmessage(ICON_ERROR.'服务器繁忙，删除失败，请重试。', 0);
			}
		}
		
		$vars = array(
    		'cid' => $cid
    	);
    	set_page_title('删除分类');
    	$this->tpl->assign($vars);
    	$this->tpl->display();		
	}
	
	public function add($cid = ''){
		
		//初始化表单值
		$category = array(
			'typename' => '',
			'action' => '',
			'sortrank' => 50,
		);
		
		$message = array();
		$msgtype = 'error';
		
		if(submitcheck('addsubmit')){
			$parentid = isset($_POST['parentid'])?intval($_POST['parentid']):0;
			$sortrank = isset($_POST['sortrank'])?intval($_POST['sortrank']):0;
			
			if(empty($_POST['typename'])){
    			$message[] = '分类名称不能为空。';
    		} else {
    			if(cnstrlen($_POST['typename']) > 16) {
    				$message[] = '分类名请控制在16个汉字(32个英文字符)之内。';
    			} else {
    				$exist = GetOne("SELECT COUNT(cid) FROM ".tname('cms_category')." WHERE typename = '{$_POST['typename']}' AND parentid='$parentid'");
    				if($exist){
    					$message[] = '同级分类下的名已经存在，请更换分类名。';
    				}
    			}
    		}
    		
    		if(empty($_POST['action'])) $message[] = '分类别名不能为空。';
			
			if($parentid < 0) {
				$message[] = '选择上级分类错误。';
			}
			if($sortrank < 0) {
				$message[] = '排序数字必须大于等于0';
			}
			
			if(empty($message)){
    			
    			$setarr = array(
    				'parentid' => $parentid,
	    			'action' => $_POST['action'],
	    			'typename' => $_POST['typename'],
	    			'sortrank' => $sortrank
    			);
    			
    			$result = inserttable('cms_category', $setarr);
    			if($result){
    				showmessage('分类添加成功', SITE_URL.'/categorycp/?addsuccess=1', 0);
    			} else {
    				$message[] = '数据库服务器繁忙，请重试。';
    			}
    		}
    		$category = $_POST;
		}
		
		$cid = isset($cid) ? intval($cid) : 0;
		$this->load->library('category');
		$selectstr = $this->category->categorySelect($cid, 'parentid', 'class="input_text" style="width:217px;"');
		$vars = array(
    		'selectstr' => $selectstr,
			'category' => $category,
			'message' => $message,
			'msgtype' => $msgtype
    	);
    	set_page_title('添加分类');
    	$this->tpl->assign($vars);
    	$this->tpl->display();
	}
	
	public function edit($cid){
		$cid = isset($cid) ? intval($cid) : 0;
		if(!$cid){
			showmessage('分类CID错误', SITE_URL.'/categorycp/');
		}
		
		
		$this->load->library('category');
		
		$category = $this->category->getMenuRow($cid);
		
		if(empty($category)){
			showmessage('该分类不存在或已被删除。', SITE_URL.'/categorycp/');
		}
		
		$message = array();
		$msgtype = 'error';
		
		if(submitcheck('editsubmit')){
			$parentid = isset($_POST['parentid'])?intval($_POST['parentid']):0;
			$sortrank = isset($_POST['sortrank'])?intval($_POST['sortrank']):0;
			
			if(empty($_POST['typename'])){
    			$message[] = '分类名称不能为空。';
    		} else {
    			if(cnstrlen($_POST['typename']) > 16) {
    				$message[] = '分类名请控制在16个汉字(32个英文字符)之内。';
    			} else {
    				$exist = GetOne("SELECT COUNT(cid) FROM ".tname('cms_category')." WHERE typename = '{$_POST['typename']}' AND parentid='$parentid' AND cid!='$cid'");
    				if($exist){
    					$message[] = '同级分类下的名已经存在，请更换分类名。';
    				}
    			}
    		}
			
			if($parentid < 0) {
				$message[] = '选择上级分类错误。';
			}
			if($sortrank < 0) {
				$message[] = '排序数字必须大于等于0';
			}
			
			if(empty($message)){
    			
    			$setarr = array(
    				'parentid' => $parentid,
    				'action' => $_POST['action'],
	    			'typename' => $_POST['typename'],
	    			'sortrank' => $sortrank
    			);
    			
    			$result = updatetable('cms_category', $setarr, array('cid'=>$cid));
    			if($result){
    				$msgtype = 'ok';
    				$message[] = '分类修改成功。';
    			} else {
    				$message[] = '数据库服务器繁忙，请重试。';
    			}
    		}
    		$category = $_POST;
		}
		
		$selectstr = $this->category->categorySelect($category['parentid'], 'parentid', 'class="input_text" style="width:217px;"');
		
		$vars = array(
    		'selectstr' => $selectstr,
			'category' => $category,
			'message' => $message,
			'msgtype' => $msgtype
    	);
    	set_page_title('修改分类');
    	$this->tpl->assign($vars);
    	$this->tpl->display();
	}
}