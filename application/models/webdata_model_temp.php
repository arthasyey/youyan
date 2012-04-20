<?php
require_once(APPPATH."inc/config.php");
require_once(APPPATH.'/inc/renren_config.php');

class webdata_Model extends CI_Model {
  function getDomainBasicInformation($domainURL){
    $query_str = "select * from domain where domain.domain='$domainURL'";
    $query_all_data = $this->db->query($query_str);
    return $query_all_data->result();
  } 
  function getFavUser($domainURL){
    $query_str = $query_str = "SELECT * FROM(SELECT *,count(*) as c FROM comment where domain='$domainURL' GROUP BY comment.user_id)a 
    JOIN user ON user.user_id = a.user_id 
      ORDER BY a.c DESC LIMIT 0,1";
    $query_user_data = $this->db->query($query_str);
    return $query_user_data->result();
  }
  function getLastVisitedUser($domainURL){
    $query_str = $query_str = "SELECT * FROM comment JOIN user ON user.user_id = comment.user_id and comment.domain='$domainURL' ORDER BY comment.time DESC LIMIT 0,8";
    $query_user_data = $this->db->query($query_str);
    return $query_user_data->result();	  
  }

  function getTable($timeArea){
    $domain = $this->input->post('domain');
    $timeLimit = '';
    if($timeArea=='all'){
      $query_str = "SELECT time FROM comment WHERE domain='$domain' ORDER BY comment.time";	
      $query_data = mysql_query($query_str);
      $timeLimit =mysql_fetch_array($query_data);					
      $timeLimit = $timeLimit[0];
      $yearLimit=((int)substr($timeLimit,0,4));
      $monthLimit=((int)substr($timeLimit,5,2));
      $dayLimit=((int)substr($timeLimit,8,2));

      $timeLimitSt = mktime(0,0,0,$monthLimit,$dayLimit,$yearLimit);

      $currentTime = time();

      $dayTime= (int)(($currentTime-$timeLimitSt)/(24*3600));
      $timeArea = $dayTime;
    }


    if(($timeArea-1)<0){
      $timeArea = 1;
    }
    $startTime = time()- $timeArea*3600*24;
    $bakStr = '[';
	$traceStr = '[';
    for($i=0;$i<=($timeArea-1);$i++){		
      $inStartTime =date("Y-m-d 00:00:00",$startTime);
      $inNextTime = date("Y-m-d 00:00:00",($startTime+3600*24));
	  $startTime = $startTime + 3600*24;
	  
	  //get comment amount
      $query_str = "SELECT count(*) FROM comment
        LEFT JOIN domain_page ON domain_page.page = comment.page
        WHERE domain_page.domain='$domain' AND to_days(comment.time)>to_days('$inStartTime') AND to_days(comment.time)<=to_days('$inNextTime')";
      $query_data = mysql_query($query_str);
      $rows =mysql_fetch_array($query_data);
	  //modify time      
      $day = date("j",$startTime);
      $month = date("n",$startTime);
      $year = date("Y",$startTime);
      $timeAxie = mktime(0,0,0,$month,$day,$year);
      if($rows[0]<0||$rows[0]==NULL){$rows[0]=0;}
      $bakStr = $bakStr.'['.$timeAxie.'000,'.$rows[0].']';
      if($i!=$timeArea-1){$bakStr = $bakStr.',';}
	  
		//get trace amount
		$query_str = "SELECT count(*) FROM page_traceback
					  WHERE page LIKE '%$domain%' AND to_days(page_traceback.time)>to_days('$inStartTime') AND to_days(page_traceback.time)<=to_days('$inNextTime')";	
      	$query_data = mysql_query($query_str);
      	$rows =mysql_fetch_array($query_data);
	  //modify time      
      $day = date("j",$startTime);
      $month = date("n",$startTime);
      $year = date("Y",$startTime);
      $timeAxie = mktime(0,0,0,$month,$day,$year);
      if($rows[0]<0||$rows[0]==NULL){$rows[0]=0;}
      $traceStr = $traceStr.'['.$timeAxie.'000,'.$rows[0].']';
      if($i!=$timeArea-1){$traceStr = $traceStr.',';}
	}
    $bakStr = $bakStr.']';
    $traceStr = $traceStr.']';
	
	return $bakStr .'{}'.$traceStr;

	
	
	
  }
  function domainCommentsPagination(){
    $this->load->library('pagination');
    $currentDomain = $_SESSION['showDomain'];
    $config['base_url'] = site_url('youyan_admin');
    $query_str = mysql_query("SELECT n_comments from domain where domain='$currentDomain'");
    $query_str = mysql_fetch_array($query_str);
    $itemAmount = $query_str["n_comments"];

    $config['total_rows'] = $itemAmount;


    $config['per_page'] = 10;
    $config['uri_segment'] = 3;  // 表示第 3 段 URL 为当前页数，如 index.php/控制器/方法/页数，如果表示当前页的 URL 段不是第 3 段，请修改成需要的数值。
    $config['prefix'] = 'index/';
    $config['full_tag_open'] = '<div class="pagination">';
    $config['full_tag_close'] = '<div class="clear"></div></div>';
    $config['first_url'] = site_url('youyan_admin')."/index/";
    $config['first_link'] = '首页';
    $config['last_link'] = '尾页';
    $config['next_link'] = '下一页';
    $config['prev_link'] = '上一页';
    $config['cur_tag_open'] = '<span class="current">';
    $config['cur_tag_close'] = '</span>';
    $config['num_links'] = 5;
    $this->pagination->initialize($config);
    $data['results'] = $this->pagination->create_links();
    return $data['results'];
  }

  function geturlList(){
    $uid = $_SESSION["uid"];
    if($uid!=''){
      $query_str = "SELECT * FROM master_domain
        LEFT JOIN domain ON domain.domain = master_domain.domain
        WHERE master_domain.master_id='$uid'";
      $query_data = $this->db->query($query_str);
      return $query_data->result();
    }
  }

  function createCSS(){
    $css = $_REQUEST['css'];
    $docName = 'user_css/'.$_SESSION['showDomain'].'.css';
    file_put_contents($docName, $css);
    return $docName;
  }

  function createCSSCrossDomain(){
    $css = $_REQUEST['css'];
    $domain = $_REQUEST['domain'];
    $docName = 'user_css/'.$domain.'.css';
    file_put_contents($docName, $css);
    return $docName;
  }



  function getVerify(){
    $uid = $_SESSION["uid"];
    $domain = $_SESSION['showDomain'];
    if($uid!=''&&$domain!=''){
      $state = mysql_query("SELECT * FROM master_domain WHERE master_id='$uid' AND domain ='$domain'");
      $state = mysql_fetch_array($state);
      if($state){
        return $state['verified'];
      }else{
        return 0;	
      }
    }else{
      return 0;
    }	
  }
  function updateLimitAmount(){
	  $limitAmount = $this->input->post('limitAmount');
	  $masterID = $_SESSION["uid"];
	  $state = mysql_query("UPDATE master SET max_email = '$limitAmount' WHERE master_id = '$masterID'");	  
	  return 1;
  }
  function updateLimitAmountCross($limitAmount,$masterID){
	  $state = mysql_query("UPDATE master SET max_email = '$limitAmount' WHERE master_id = '$masterID'");	  
	  return 1;
  }
}

