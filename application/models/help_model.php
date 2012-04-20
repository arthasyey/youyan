<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-8-14上午02:22:06
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

	public function get_total($wheresql){
		$sql = "SELECT COUNT(helpid) FROM ".tname('help')." WHERE $wheresql";
		if($total = GetOne($sql)){
			return $total;
		}
		return 0;
	}
	
	public function get_list($wheresql, $limitsql) {
		$sql = "SELECT *  
			FROM ".tname('help')."
			WHERE $wheresql 
			ORDER BY addtime DESC   
			LIMIT $limitsql";
		$query = $this->db->query($sql);
		$list = array();
		if($query){
			foreach ($query->result_array() as $row){
				$row['addtime'] = date('Y-m-d H:i', $row['addtime']);
				$list[] = $row;
			}
		}
		return $list;
	}
	
	public function get_help($value, $field = 'helpid', $decode = 1){
		$sql = "SELECT *  
			FROM ".tname('help')."
			WHERE $field = '$value'";
		if($help = GetRow($sql)){
			if($decode){
				$help['content'] = str_ireplace('&lt;textarea', '<textarea', $help['content']);
    			$help['content'] = str_ireplace('&lt;/textarea&gt;', '</textarea>', $help['content']);
			}
    		return $help;
		}
		return FALSE;
	}
	
	public function help_delete($helpid){
    	return $this->db->query("DELETE FROM ".tname('help')." WHERE helpid='$helpid'");
    }
}