<?php
class YouYan_Hot_Comment extends CI_Controller {
  function __construct(){
    parent::__construct();
	$this->load->model('comment_model');
  }


  /**
   * 热评榜单
   */
  function index(){
	//parepared data $domain and $type	
	$master_id = $_GET['master_id'];
	$domain = $_GET['domain'];
	$rankType = $_GET['rankType'];
	
    $configure_data = array();
    if($this->verifyDomain($master_id, $domain, $configure_data) == 0){
      echo '嵌入评论框代码有错, 站长ID无效';
      return;
    }	
	$query_domain = $this->db->where('domain', $domain)->get('domain');
    $query_result = $query_domain->row_array();
    $configure_data = $query_result;
    $_SESSION['uyan_domain_data'] = $configure_data;
    $data['config'] = $configure_data;	
	$data['domain'] = $domain;
	$data['rank_type'] = $rankType;
	$data['main_content'] = 'youyan_hot_comment_view';
	$this->load->view('youyan_hot_comment_view',$data);
  }

  function getHotComment(){
	$this->load->model('comment_model');
	echo json_encode($this->comment_model->getHotComments());
  }
  //verifyDomain  
 /**
   * Check if the domain is verified, if the user_id doesn't exsit, return 0;
   * Otherwise, if the user_id--domain pair do not exsit, put in the 
   * correlation.
   * Otherwise, the correlation exsit, but it's not verified, set it to be 1
   */
  function verifyDomain($master_id, $domain, &$configure_data){
	$domain = $this->post_check_domain($domain);
    $this->db->where('master_id', $master_id)->from('master');
    if($this->db->count_all_results() == 0){
      return 0;
    }
	if($master_id==0||$master_id=='0'||$master_id==''){
	  return 0;
	}
	//check whether current master is verified.
    $this->db->where('master_id', $master_id)->where('domain', $domain)->where('verified' ,1);
    $this->db->from('master_domain');
    $query_result = $this->db->count_all_results();

    $new_domain = 0;
    if($query_result == 0){
	  //when the master is not verified.
	  //get other states
	  $stateOthers = mysql_query("SELECT count(*) FROM master_domain WHERE domain='$domain' AND verified=1");
	  $stateOthers = mysql_fetch_array($stateOthers);
	  if($stateOthers[0]<1){
		//no one is verified
		//verify current master
		  mysql_query("UPDATE master_domain SET verified=2 WHERE domain='$domain'");
		  $this->db->where('master_id', $master_id)->where('domain', $domain)->from('master_domain');
		  $query_record = $this->db->count_all_results();
	
		  if($query_record != 0){                                 
		  // Paire exsits, but not verified, set it to be verified
			$this->db->set('verified', 1)->where('master_id', $master_id)->where('domain', $domain)->update('master_domain');
		  }else{                                                    
		  // Pair does not exist, the domain is also not created 	   
			$data = array(
			  'master_id' => $master_id,
			  'domain' => $domain,
			  'verified' => 1
			);
			$this->db->insert('master_domain', $data);
		  }		
	  }else{
		//some one has verified this domain,so the master has to upload a file to confirm his control.		
		mysql_query("UPDATE master_domain SET verified=2 WHERE domain='$domain' AND master_id='$master_id'");
	  }
	  // if the domain is not exisited then create it
      $this->db->where('domain', $domain)->from('domain'); 
      $count = $this->db->count_all_results();
      if($count == 0){
        $data_domain = array(
          'domain' => $domain,
          'time' => date('Y-m-d H:i:s')
        );
        $this->db->insert('domain', $data_domain);
        $new_domain = 1;
      }
    }
	
    $query_domain = $this->db->where('domain', $domain)->get('domain');
    $query_result = $query_domain->row_array();
    $configure_data = $query_result;

    //if($new_domain)
      //$this->postInitialPageComment($configure_data);
    return 1;
  }
  function post_check_domain($post) {     
    if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否为打开     
      $post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤     
    }     
    $post = str_replace("_", "\_", $post);    // 把 '_'过滤掉     
    $post = str_replace("%", "\%", $post);    // 把 '%'过滤掉     
    $post = nl2br($post);    // 回车转换     
    $post = htmlspecialchars($post);    // html标记转换

    return $post;     
  }
  //end
}
?>
