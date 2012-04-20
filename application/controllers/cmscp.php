<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-9-25下午05:10:07
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cmscp extends CI_Controller {

	/**
	 * 
	 * @var Cms_model
	 */
	public $cmsmod;
	
	/**
	 *
	 * @var Check_model
	 */
	public $ckmod;
	
    public function __construct(){
    	parent::__construct();
    	$RTR =& load_class('Router');
    	ck_adminlogin();
    	$this->load->model('Cms_model', 'cmsmod');
    	$this->load->model('Check_model', 'ckmod');
    	set_module_title('内容管理');
    }
    
	public function index(){
		
		$addsuccess = isset($_GET['addsuccess']) ? intval($_GET['addsuccess']) : 0;
		
		$stime = empty($_GET['stime']) ? '' : $_GET['stime'];
		$etime = empty($_GET['etime']) ? '' : $_GET['etime'];
		
		$subject = empty($_GET['subject']) ? '' : $_GET['subject'];
		
		$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
		$this->load->library('category');
		$selectstr = $this->category->categorySelect($cid, 'cid', 'class="input_text" style="width:150px;"', '全部分类');
		
		$cidstr = '';
		if($cid > 0){
			$cidstr .= $cid;
			$child = $this->category->get_child($cid);
			if($child){
				foreach ($child as $val){
					$cidstr .= ','.$val['cid'];
				}
			}
		}
		
		$wheresql = "1";
		if(!empty($stime)) $wheresql .= " AND addtime>='".strtotime($stime.' 00:00:00')."'";
		if(!empty($etime)) $wheresql .= " AND addtime<='".strtotime($etime.' 23:59:59')."'";
		if(!empty($subject)) $wheresql .= " AND subject LIKE '%{$subject}%'";
		if(!empty($cidstr)) $wheresql .= " AND cid IN ({$cidstr})";
		
		$this->load->library('page');
		$this->page->pernum = 5;//页码偏移量
		$pagesize = 20;//每页显示数量
		$total = $this->cmsmod->get_total($wheresql);
		$page = $this->page->getpage($total, $pagesize);
		
		$list = $this->cmsmod->get_list($wheresql, $this->page->limit);
		
		$vars = array(
			'addsuccess' => $addsuccess,
			'list' => $list,
			'page' => $page,
			'subject' => $subject,
			'selectstr' => $selectstr,
			'stime' => $stime,
			'etime' => $etime,
		);
		$this->tpl->assign($vars);
		$this->tpl->display();
	}
    
    public function add(){
    	
    	//初始化表单值
		$cms = array(
			'subject' => '',
			'cid' => isset($_GET['cid']) ? intval($_GET['cid']) : 0,
			'seourl' => '',
			'content' => ''
		);
    	
    	$message = array();
		$msgtype = 'error';
		
    	if(submitcheck('addsubmit')){
    		
    		$cid = isset($_POST['cid'])?intval($_POST['cid']):0;
    		
    		if(empty($_POST['subject'])){
    			$message[] = '内容标题不能为空。';
    		}
    		
    		if(!$cid){
    			$message[] = '请选择分类。';
    		}
    		
    		if(!empty($_POST['seourl'])){
	    		$result = $this->ckmod->check_cms_seourl($_POST['seourl']);
				if($result != 'OK'){
					$message[] = $result;
				}
    		} else {
    			$_POST['seourl'] = '';
    		}
    		
    		if(!empty($_POST['content'])){
    			$_POST['content'] = str_ireplace('<textarea', '&lt;textarea', $_POST['content']);
    			$_POST['content'] = str_ireplace('</textarea>', '&lt;/textarea&gt;', $_POST['content']);
    			$_POST['content'] = addslashes($_POST['content']);
    		} else {
    			$message[] = '内容不能为空。';
    		}
    		
    		
    		if(empty($message)){
    			
    			$setarr = array(
    				'subject' => $_POST['subject'],
	    			'cid' => $cid,
	    			'seourl' => $_POST['seourl'],
	    			'content' => $_POST['content'],
    				'addtime' => SITE_TIME
    			);
    			
    			$cmsid = inserttable('cms', $setarr, 1);
    			if($cmsid){
    				if(empty($_POST['seourl'])){
    					updatetable('cms', array('seourl'=>$cmsid), array('cmsid'=>$cmsid));
    				}
    				showmessage('操作成功', SITE_URL.'/cmscp/?addsuccess=1', 0);
    			} else {
    				$message[] = '数据库服务器繁忙，请重试。';
    			}
    		}
    		$cms = sstripslashes($_POST);
    	}
    	
    	$this->load->library('category');
		$selectstr = $this->category->categorySelect($cms['cid'], 'cid', 'class="input_text" style="width:217px;"');
    	
    	
    	$vars = array(
    		'cms' => $cms,
    		'selectstr' => $selectstr,
			'message' => $message,
			'msgtype' => $msgtype
		);
		$this->tpl->assign($vars);
		set_page_title('添加内容');
		$this->tpl->display();
    }
    
    
	public function edit($cmsid){
		$_POST['addtime'] = strtotime(isset($_POST['addtime']) ? $_POST['addtime'] : '');
		$cmsid = isset($cmsid) ? intval($cmsid) : 0;
		if(!$cmsid) showmessage('内容ID参数错误。', 0);
			
		$cms = $this->cmsmod->get_cms($cmsid, 'cmsid', 0);
		if(!$cms) showmessage('该内容不存在。', 0);
		
		$message = array();
		$msgtype = 'error';
		
		if(submitcheck('editsubmit')){
			$cid = isset($_POST['cid'])?intval($_POST['cid']):0;
    		
    		if(empty($_POST['subject'])){
    			$message[] = '内容标题不能为空。';
    		}
    		
    		if(!$cid){
    			$message[] = '请选择分类。';
    		}
    		if(empty($_POST['seourl'])){
    			$_POST['seourl'] = $cms['cmsid'];
    		} else {
	    		if($_POST['seourl'] != $cms['seourl']){
					$result = $this->ckmod->check_cms_seourl($_POST['seourl']);
					if($result != 'OK'){
						$message[] = $result;
					}
				}
    		}
			
    		if(!empty($_POST['content'])){
				$_POST['content'] = str_ireplace('<textarea', '&lt;textarea', $_POST['content']);
    			$_POST['content'] = str_ireplace('</textarea>', '&lt;/textarea&gt;', $_POST['content']);
    			$_POST['content'] = addslashes($_POST['content']);
    		} else {
    			$message[] = '内容不能为空。';
    		}
    		
    		$cms = sstripslashes($_POST);
    		
			if(empty($message)){
    			$setarr = array(
    				'subject' => $_POST['subject'],
	    			'cid' => $cid,
	    			'seourl' => $_POST['seourl'],
	    			'content' => $_POST['content'],
					'addtime' => $_POST['addtime']
    			);
    			
    			if(updatetable('cms', $setarr, array('cmsid'=>$cmsid))){
    				
    				$cmsurl = $this->cmsmod->get_cms_url($cms['cid'], $cms['seourl']);
    				
    				$msgtype = 'ok';
					$message[] = '内容已经成功更新！<a href="'.$cmsurl.'" target="_blank"><u style="color:red">点此查看更新后的内容</u></a>';
    			} else {
    				$message[] = '数据库服务器繁忙，请重试。';
    			}
    		}
		}
		
		$this->load->library('category');
		$selectstr = $this->category->categorySelect($cms['cid'], 'cid', 'class="input_text" style="width:217px;"');

		$cms['content'] = newhtmlspecialchars($cms['content']);
		
		$vars = array(
			'cms' => $cms,
			'selectstr' => $selectstr,
			'message' => $message,
			'msgtype' => $msgtype,
			'addtime' => $_POST['addtime']
		);
		$this->tpl->assign($vars);
		
		set_page_title('修改内容');
		$this->tpl->display();
	}
    
    
    
	public function delete($cmsid){
		
		$cmsid = isset($cmsid) ? intval($cmsid) : 0;
		
		if(!$cmsid) showmessage('cmsID参数错误。', 0);
		
    	if($cms = $this->cmsmod->get_cms($cmsid)){
    		if(submitcheck('deletesubmit')){
    			$result = $this->cmsmod->cms_delete($cmsid);
    			if($result){
    				showmessage(ICON_OK.'该内容已经成功被删除。', 0);
    			} else {
    				showmessage(ICON_ERROR.'服务器繁忙，删除失败，请重试。', 0);
    			}
    		}
    	} else {
    		if(!$cms) showmessage('该内容不存在。', 0);
    	}
		
		$vars = array(
    		'cmsid' => $cmsid
    	);
    	set_page_title('删除内容');
    	$this->tpl->assign($vars);
    	$this->tpl->display();
	}
}