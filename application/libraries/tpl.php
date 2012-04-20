<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-7-24下午06:10:01
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'smarty-3.1.3/Smarty.class.php';

class Tpl extends Smarty {

    public function __construct() {
        parent::__construct();

        $this->set_tpl_dir();

        $this->config_dir = SMARTY_CONFIG_DIR;
        $this->debugging = SMARTY_DEBUGGING;
        $this->left_delimiter = SMARTY_LEFT_DELIMITER;
        $this->right_delimiter = SMARTY_RIGHT_DELIMITER;
        $this->force_compile = SMARTY_FORCE_COMPILE;
        $this->compile_check = SMARTY_COMPILE_CHECK;
        //$this->suffix_name = SMARTY_SUFFIX_NAME;
        $this->caching = SMARTY_CACHING;
        if(OPEN_DEBUG) {
            //开启debug模式打印CI系统的调试信息
        	$CI =& get_instance();
        	$CI->output->enable_profiler(TRUE);
        }
    }

    /**
     * @desc 重写Smarty::display()
     * @see application/libraries/smarty-3.1.3/sysplugins/smarty_internal_templatebase.php
     * #display($template = null, $cache_id = null, $compile_id = null, $parent = null)
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {
        if(empty($template)){
            $template = get_tpl_resource_name();
        }
        //在输出视图之前预先注册smarty变量
        tplinit();

        $resource = $this->fetch($template, $cache_id, $compile_id, $parent, false);

        if(INAJAX){
        	$this->xml_out($resource);
        } else {
	    	if(OPEN_DEBUG) {
	            $CI =& get_instance();
	            $debug_query = array();
	            foreach ($CI->db->queries as $key=>$sql){
	                $explain = array();
	                if(preg_match("/^(select )/i", $sql)) {
	                    $query = $CI->db->query("EXPLAIN ".$sql);
	                    //$explain = $query->row_array();
	                }
	                $query_times = number_format($CI->db->query_times[$key], 4);
	                $debug_query[] = array('sql'=>$sql, 'query_times'=>$query_times, 'explain'=>$explain);
	            }
	            show_debug($debug_query);
	            echo $resource;
	        } else {
	            echo $resource;
	        }
        }
    }

    /**
     * @desc 输出xml
     * @param $resource
     */
	public function xml_out($resource) {
		$CI =& get_instance();

		@header("Expires: -1");
		@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
		@header("Pragma: no-cache");
		@header("Content-type: application/xml; charset=".$CI->config->item('charset'));
		echo '<'."?xml version=\"1.0\" encoding=\"".$CI->config->item('charset')."\"?>\n";
		echo "<root><![CDATA[".trim($resource)."]]></root>";
		exit();
	}

    /**
     * @desc 设置模板目录
     * @param $dir
     */
    public function set_tpl_dir($dir = '') {
        $template_dir = SMARTY_TEMPLATES_DIR.'/'.THEME.'/';
        $compile_dir = SMARTY_COMPILE_DIR.'/'.THEME.'/';
        $cache_dir = SMARTY_CACHE_DIR.'/'.THEME.'/';

        if(!empty($dir)){
            $dir = strtolower($dir);
            $template_dir .= $dir.'/';
            $compile_dir .= $dir.'/';
            $cache_dir .= $dir.'/';
        }
        if(!is_dir($compile_dir))
            mkdir($compile_dir,0777,true);
        if(!is_dir($cache_dir))
            mkdir($cache_dir,0777,true);

        $this->template_dir = $template_dir;
        $this->compile_dir = $compile_dir;
        $this->cache_dir = $cache_dir;
    }
}
