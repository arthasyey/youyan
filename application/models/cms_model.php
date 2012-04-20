<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-9-25下午05:12:19
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

	public function get_total($wheresql){
		$sql = "SELECT COUNT(cmsid) FROM ".tname('cms')." WHERE $wheresql";
		if($total = GetOne($sql)){
			return $total;
		}
		return 0;
	}
	
	public function get_list($wheresql, $limitsql) {
		$sql = "SELECT *  
			FROM ".tname('cms')."
			WHERE $wheresql 
			ORDER BY addtime DESC   
			LIMIT $limitsql";
		$query = $this->db->query($sql);
		$list = array();
		if($query){
			$this->load->library('category');
			foreach ($query->result_array() as $row){
				$row['addtime'] = date('Y-m-d H:i', $row['addtime']);
				$row['linkurl'] = $this->get_cms_url($row['cid'], $row['seourl']);
				$row['category'] = $this->category->getMenu($row['cid']);
				$list[] = $row;
			}
		}
		return $list;
	}
	
	public function get_cms_url($cid, $seourl = ''){
		$this->load->library('category');
		$category = $this->category->get_top_cate($cid);
		$seourl = $seourl ? $seourl : $cid;
		$linkurl = SITE_URL;
		
		if($category) {
			$linkurl .= "/{$category['action']}/";
			$actions = array('help', 'news', 'cms', 'report','faq');
			
			if(in_array($category['action'] ,$actions)){
				if($category['action'] == "news" && $seourl=="smo"){
					$linkurl = SITE_URL."/smo/";
				}else if($category['action'] == "faq" && $seourl=="faq"){
					$linkurl = SITE_URL."/faq/";
				}else {
					$linkurl .= "html/{$seourl}/";
				}
			}
		}
		return $linkurl;
	}
	
	function get_cms_byseourl($seourl=''){
		$sql = "SELECT *
		FROM ".tname('cms')."
		WHERE seourl='$seourl'";
		return GetRow($sql);
	}
	
	public function get_cms($value, $field = 'cmsid', $decode = 1){
		
		$sql = "SELECT *  
			FROM ".tname('cms')."
			WHERE $field = '$value'";
		$cms = GetRow($sql);
		if($cms === FALSE){
			return FALSE;
		} else {
			if(!empty($cms)){
				if($cms['seourl'] == 'support-media-website'){
					$html = '<table id="ckepop" style="padding-top: 20px;" border="0" width="100%">';
					$html .= '<tbody>';
					$html .= '<tr height="50">';
					$html .= '<td colspan="2"><strong>网站名称</strong></td>';
					$html .= '<td><strong>WEBID</strong></td>';
					$html .= '<td><strong>URL</strong></td>';
					$html .= '</tr>';
					
					$medias = cache_read('shareservice');
	
					foreach ($medias as $webid=>$media){
						if($media['status'] == 1){
							$html .= '<tr>';
							$html .= '<td width="20"><span class="jtico jtico_'.$webid.'"></span></td>';
							$html .= '<td width="180">'.$media['sitename'].'</td>';
							$html .= '<td width="180">'.$webid.'</td>';
							$html .= '<td><a href="'.$media['siteurl'].'" target="_blank" style="font-size:12px;color:#333;">'.$media['siteurl'].'</a></td>';
							$html .= '</tr>';
						}
					}
					$html .= '</tbody>';
					$html .= '</table>';
					$cms['content'] = $html;
				}
				
				if($decode){
					$cms['content'] = str_ireplace('&lt;textarea', '<textarea', $cms['content']);
	    			$cms['content'] = str_ireplace('&lt;/textarea&gt;', '</textarea>', $cms['content']);
				}
			}
			return $cms;
		}
		
	}
	
	public function cms_delete($cmsid){
    	return $this->db->query("DELETE FROM ".tname('cms')." WHERE cmsid='$cmsid'");
    }
    
    public function get_child_by_cid($cid, $orderaddtime = "DESC"){
    	$this->load->library('category');
    	$child = $this->category->get_child($cid);
    	$result = array();
    	if($child){
    		foreach($child as $val){
    			$val['child'] = $this->get_child_by_cid($val['cid'], $orderaddtime);
    			$val['cms'] = $this->get_cms_by_cid($val['cid'], $orderaddtime);
    			$result[] = $val;
    		}
    	}
    	return $result;
    }
    
     public function get_cms_by_cid($cid, $orderaddtime = "DESC"){
     	//该分类下的所有内容标题
		$sql = "SELECT cmsid,subject,seourl,addtime   
			FROM ".tname('cms')." 
			WHERE cid='{$cid}' 
			ORDER BY addtime $orderaddtime";
		$query = $this->db->query($sql);
		$cms = array();
     	if($query){
			foreach ($query->result_array() as $row){
				$row['shorttitle'] = getstr($row['subject'], 24);
				$cms[] = $row;
			}
		}
		return $cms;			
     }
     
     public function get_directory($action = ''){
     	$cms_directory = cache_read('cms_directory');
     	$directory = array();
     	if(empty($action)){
     		$directory = $cms_directory;
     	} else {
	     	foreach ($cms_directory as $val){
		     	if($action == $val['action']){
					if($val['cms']){
						$directory = array($val);
					} else if($val['child']){
						$directory = $val['child'];
					} else {
						$directory = $val;
					}
		     	} 
	     	}
     	}
     	return $directory;
     }
}