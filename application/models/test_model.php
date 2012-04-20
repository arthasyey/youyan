<?php
/**
 * @copyright	© 2009-2011 JiaThis Inc.
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2011-10-10
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_model extends CI_Model {
	
	public function get_list() {
		
		$sql = "SELECT *  
			FROM ".tname('member')."
			WHERE 1 
			ORDER BY regtime DESC  
			LIMIT 0,100";
		
		$query = $this->db->query($sql);
		$list = array();
		if($query){
			foreach ($query->result_array() as $row){
				$list[] = $row;
			}
		}
		
		return $list;
	}
}