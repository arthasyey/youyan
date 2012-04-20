<?php
class User_Model extends CI_Model {

  /*
   @Param:   $query_result: the result of querying a user
   @Return:  the array of binded accounts (sina, renren, etc.)
   从查询结果(domaim)中获取结构化的信息
   */
  function get_binded_accounts($query_result){
    $ret = array();

    $ret['youyan'] = array('id' => $query_result->user_id, 'user_name' => $query_result->user_name, 'show_name' => $query_result->show_name, 'profile_img' => $query_result->profile_img);

    if($query_result->sso_id){
      $ret['sso'] = array('sso_id' => $query_result->sso_id, 'sso_name' => $query_result->sso_name, 'sso_show_name' => $query_result->sso_show_name, 'sso_home' => $query_result->sso_home, 'sso_link' => $query_result->sso_link);
    }

    if($query_result->sina_id){
      $ret['sina'] = array('id' => $query_result->sina_id, 'access_token' => $query_result->sina_access_token, 'access_secret' => $query_result->sina_access_secret);
    }

    if($query_result->renren_id){
      $ret['renren'] = array('id' => $query_result->renren_id);
    }

    if($query_result->kaixin_id){
      $ret['kaixin'] = array('id' => $query_result->kaixin_id);
    }

    if($query_result->sohu_id){
      $ret['sohu'] = array('id' => $query_result->sohu_id, 'access_token' => $query_result->sohu_access_token, 'access_secret' => $query_result->sohu_access_secret);
    }

    if($query_result->neteasy_id){
      $ret['neteasy'] = array('id' => $query_result->neteasy_id);
    }

    if($query_result->tencent_id){
      $ret['tencent'] = array('id' => $query_result->tencent_id, 'access_token' => $query_result->tencent_access_token, 'access_secret' => $query_result->tencent_access_secret);
    }

    /*if($query_result->douban_id){
      $ret['douban'] = array('id' => $query_result->douban_id, 'access_token' => $query_result->douban_access_token, 'access_secret' => $query_result->douban_access_secret);
    }*/

    if($query_result->qq_id){
      $ret['qq'] = array('id' => $query_result->qq_id);
    }

    if($query_result->msn_id){
      $ret['msn'] = array('id' => $query_result->msn_id, 'link' => $query_result->msn_link);
    }
    return $ret;
  }




  /**
   * 没有使用，留作账号绑定用函数
   */
  function bind_account($user_id, $with_type, $metadata){
    $query = $this->db->select('profile_img')->where('user_id', $user_id)->get('user');
    $query_results = $query->result();
    $query_result = $query_results[0];
    //var_dump($query_result);
    if($query_result->profile_img == '')
      $metadata['profile_img'] = $metadata[$with_type.'_profile_img'];

    if($query_result->show_name == '')
      $metadata['show_name'] = $metadata[$with_type.'_show_name'];

    $this->db->where('user_id', $user_id);
    $ret = $this->db->update('user', $metadata);
    //print_r($ret);
  }


  /**
   * 判断某种登录方式，某种id的用户是否存在
   */
  function user_exist($login_id_type, $login_id){
    $query = $this->db->where($login_id_type, $login_id)->get('user');
    if($query->num_rows != 0)
      return true;
    else
      return false;
  }  


  /**
   * 创建用户，第一个参数为来源（新浪，腾讯。。。），第二个为用户账户基本信息
   */
  function create_user($from_type, $metadata){
    if($from_type != 'youyan' && $from_type != 'sso'){
      $metadata['profile_img'] = $metadata[$from_type.'_profile_img'];
      $metadata['show_name'] = $metadata[$from_type.'_show_name'];
    }
    
    else if($from_type == 'sso'){
      /* Get info about the login SSO */
      $query = $this->db->where('sso_name', $metadata['sso_name'])->get('domain');
      if($query->num_rows() == 0)
        return 0;
      $sso_basic_info = $query->row_array();

      $metadata['sso_id'] = $metadata['sso_name'] . '_' . $metadata['id'];
      unset($metadata['id']);
      
      $metadata['show_name'] = $metadata['username'];
      unset($metadata['username']);

      if(isset($metadata['link'])){
        $metadata['sso_link'] = $metadata['link'];
        unset($metadata['link']);
      }

      $metadata['sso_home'] = $sso_basic_info['domain'];
      $metadata['sso_show_name'] = $sso_basic_info['domain_name'];
    }

    $metadata['register_date'] = date('Y-m-d H:i:s');

    $insert_query = $this->db->insert('user', $metadata);

    if($insert_query == 1){
      $new_user_id = $this->db->insert_id();
      /*$new_row_query = $this->db->where('user_id', $new_user_id)->get('user');
      $new_row_query_results = $new_row_query->result();*/
      return $new_user_id; //$new_row_query_results[0]->user_id;
    }
    else
      return 0;
  }


  /**
   * @Param: $is_ajax:  the request is passed as ajax or not, decides where to 
   *                    get the data
   * @Return:           the query data of new inserted account
   * 登陆用户
   */
  function login($is_ajax = true, $is_binding = false){
    if($is_ajax){
      $login_id_type = $this->input->post('login_id_type');
      $login_id = $this->input->post('login_id');
    }
    else{
      $args = func_get_args();
      $login_id_type = $args[1];
      $login_id = $args[2];
    }

    if($login_id_type != 'user_id' && $login_id_type != 'email' && $login_id_type != 'user_name')
      $query = $this->db->where($login_id_type, $login_id)->get('user');

    /* Here, the login id type is 'user_id', 'email', or 'user_name'*/
    else{
      if($is_ajax)
        $password = $this->input->post('password');
      else
        $password = $args[3];

      $password = md5($password, false);

      /* if it's just login, just do it */
      if(!$is_binding){
        $query = $this->db->where($login_id_type, $login_id)->where('password', $password)->get('user');
      }


      /* otherwise, it's binding with an existing user account */
      else{
        $metadata = $_SESSION['candidate_bind_data'];
        $this->db->where($login_id_type, $login_id)->where('password', $password)->update('user', $metadata);
        $query = $this->db->where($login_id_type, $login_id)->get('user');
      }
    }

    if($query->num_rows != 0){
      $query_result = $query->result();
      return $query_result[0];
    }
    else
      return false;
  }


  function validate()
  {
    #echo $this->input->post('username');
    #echo md5($this->input->post('password'));
    $this->db->where('username', $this->input->post('username'));
    #$this->db->where('password', md5($this->input->post('password')));
    $query = $this->db->get('membership');
    #echo $query->num_rows;	
    if($query->num_rows == 1)
    {
      return true;
    }
  }


  /**
   * 网站主注册（跨域注册，用于来自wordpress插件的注册
   */
  function signupMasterCrossDomain(){
    $targetURL = strtolower($_REQUEST['targetURL']);
	$targetURL = $this->post_check($targetURL);
    $targetPS = md5($_REQUEST['targetPS']);
    $targetName = $_REQUEST['targetName'];
	$targetName = $this->post_check($targetName);
    $targetEmail = strtolower($_REQUEST['targetEmail']);
	$targetEmail = $this->post_check($targetEmail);
    if($targetURL!=''&&$targetPS!=''&&$targetName!=''&&$targetEmail!=''){
      $state = "SELECT count(*) FROM master WHERE email='$targetEmail'";
      $state  = mysql_query($state  );
      $state  = mysql_fetch_array($state );
      if($state[0]==0){
        $data = array(
          'password' => $targetPS,
          'email' => $targetEmail,
          'nick' => $targetName,
          'time' => date('Y-m-d H:i:s')
        );
        $query_insert = $this->db->insert('master', $data);
        $query_str = "SELECT @@IDENTITY";
        $query_obj = mysql_query($query_str );
        $query_obj = mysql_fetch_array($query_obj);
        $masterID = $query_obj[0];
		//check domain signup state. if domain has been added and verified, notify the domain has been added. please upload a file to verify your control.
	  $domainState = mysql_query("SELECT count(*) FROM master_domain WHERE domain = '$targetURL' AND verified = 1");
	  $domainState = mysql_fetch_array($domainState);
	  if($domainState[0]>=1){
		  //the lock state happend, user must upload a file to verify.
        $query_str = "INSERT INTO master_domain (master_id,domain, verified)VALUE('$masterID','$targetURL', 2)";
	  }else{
		$query_str = "INSERT INTO master_domain (master_id,domain, verified)VALUE('$masterID','$targetURL', 0)"; 
	  }
        $query_insert = $this->db->query($query_str);

        $domainState = mysql_query("SELECT count(*) as amount FROM domain  WHERE domain = '$targetURL'");
        $domainState = mysql_fetch_array($domainState);
        if($domainState['amount']==0){
          $data = array(
            'domain' => $targetURL,
            'time' => date('Y-m-d H:i:s')
          );
          $query_insert = $this->db->insert('domain', $data);
        }

        $query = $this->db->query("select * from domain where domain='$targetURL'");
        $query_arr = $query->row_array();
        $query_arr["uname"] = $targetName;
        $query_arr["domain"] = $targetURL;
        $query_arr['uid'] = $masterID;

        $docName = 'user_css/'.$targetURL.'.css';		        // Prepare for the css files
        if(!file_exists($docName)){
          file_put_contents($docName, ' ');
        }		
		$docNameComment = 'user_css/comment/'.$targetURL.'.css';
        if(!file_exists($docNameComment)){
          file_put_contents($docNameComment, ' ');
        }		
		$docNameArticle = 'user_css/article/'.$targetURL.'.css';
        if(!file_exists($docNameArticle)){
          file_put_contents($docNameArticle, ' ');
        }	
        $docName = 'spam_words/'.$targetURL.'.txt';		        // Prepare for the spam words files
        $dicName = 'spam_dics/' .$targetURL;
        if(!file_exists($docName)){
          copy('spam_words/template.txt', $docName);
          $ret = system("./dpp $docName $dicName");
        }
        return $query_arr;
      }else{
        return 0;
      }
    }
  }

  /**
   * 注册网站主账户
   */
  function signupMaster(){
    $targetURL = strtolower($_REQUEST['targetURL']);
    $pattern = '/^(https?|ftp|mms):\/\//';
    $targetURL = preg_replace($pattern,'',$targetURL);
    $pattern = '/\/$/';
    $targetURL = preg_replace($pattern,'',$targetURL);
	$targetURL = $this->post_check($targetURL);
    $targetPS = md5($_REQUEST['targetPS']);
    // $targetName = $_REQUEST['targetName'];
    $tmpName = explode('@', $_REQUEST['targetEmail']);
    $targetName = $tmpName[0];
	$targetName  = $this->post_check($targetName );
    $targetEmail = strtolower($_REQUEST['targetEmail']);
	$targetEmail  = $this->post_check($targetEmail);
    if($targetPS!=''&&$targetName!=''&&$targetEmail!=''){
      $state = "SELECT count(*) FROM master WHERE email='$targetEmail'";
      $state  = mysql_query($state);
      $state  = mysql_fetch_array($state );
      if($state[0]==0){
        $data = array(
          'password' => $targetPS,
          'email' => $targetEmail,
          'nick' => $targetName,
          'time' => date('Y-m-d H:i:s')
        );        
        $query_insert = $this->db->insert('master', $data);
        $query_str = "SELECT @@IDENTITY";
        $query_obj = mysql_query($query_str );
        $query_obj = mysql_fetch_array($query_obj);
        $masterID = $query_obj[0];
	  //check domain signup state. if domain has been added and verified, notify the domain has been added. please upload a file to verify your control.
	  $domainState = mysql_query("SELECT count(*) FROM master_domain WHERE domain = '$targetURL' AND verified = 1");
	  $domainState = mysql_fetch_array($domainState);
	  if($domainState[0]>=1){
		  //the lock state happend, user must upload a file to verify.
		 $query_str = "INSERT INTO master_domain (master_id,domain,verified)VALUE('$masterID','$targetURL',2)";
	  }else{
		 $query_str = "INSERT INTO master_domain (master_id,domain,verified)VALUE('$masterID','$targetURL',0)";
	  }
        
        $query_insert = $this->db->query($query_str);
//check the domain has already exist
//the setting will take effect based on the master_id
        $domainState = mysql_query("SELECT count(*) as amount FROM domain  WHERE domain = '$targetURL'");
        $domainState = mysql_fetch_array($domainState);
        if($domainState['amount']==0){
          $data = array(
            'domain' => $targetURL,
            'time' => date('Y-m-d H:i:s')
          );
          $query_insert = $this->db->insert('domain', $data);
        }
        $_SESSION["uname"] = $targetName;
        $_SESSION["domain"] = $targetURL;
        $_SESSION['uid'] = $masterID;
        $_SESSION['showDomain'] = $targetURL;
        $docName = 'user_css/'.$targetURL.'.css';		
        if(!file_exists($docName)){
          file_put_contents($docName, ' ');
        }
		$docNameComment = 'user_css/comment/'.$targetURL.'.css';
        if(!file_exists($docNameComment)){
          file_put_contents($docNameComment, ' ');
        }		
		$docNameArticle = 'user_css/article/'.$targetURL.'.css';
        if(!file_exists($docNameArticle)){
          file_put_contents($docNameArticle, ' ');
        }	
        $docName = 'spam_words/'.$targetURL.'.txt';		        // Prepare for the spam words files
        $dicName = 'spam_dics/' .$targetURL;
        if(!file_exists($docName)){
          copy('spam_words/template.txt', $docName);
          $ret = system("./dpp $docName $dicName");
        }
        $domain_query = $this->db->query("select * from domain where domain='$targetURL'");
        $domain = $domain_query->row_array();
        $_SESSION['domain_data'] = $domain;
		if($domainState[0]>=1){
			return $targetName . '{}' . $targetURL . '{}' . $masterID . '{}2';
		}else{
        	return $targetName . '{}' . $targetURL . '{}' . $masterID;
		}
      }else{
        return 0;
      }
    }
  }


  /**
   * 添加网站主账户
   */
  function addWebMaster(){
    $targetURL = $this->input->post('targetURL');
    $targetURL = strtolower($targetURL);
    $pattern = '/^(https?|ftp|mms):\/\//';
    $targetURL = preg_replace($pattern,'',$targetURL);
    $pattern = '/\/$/';
    $targetURL = preg_replace($pattern,'',$targetURL);
	$targetURL = $this->post_check($targetURL);
    if($targetURL!=''&&$_SESSION["uid"]!=''){
      $uid = $_SESSION["uid"];
      $state = "SELECT count(*) FROM master_domain WHERE master_domain.domain='$targetURL' AND master_domain.master_id = '$uid'";
      $state = mysql_query($state);
      $state = mysql_fetch_array($state);
      if($state[0]==0){
			  //check domain signup state. if domain has been added and verified, notify the domain has been added. please upload a file to verify your control.
	    $domainState = mysql_query("SELECT count(*) FROM master_domain WHERE domain = '$targetURL' AND verified = 1");
	    $domainState = mysql_fetch_array($domainState);
	    if($domainState[0]>=1){
       		$query_str = "INSERT INTO master_domain (master_id,domain,verified)VALUE('$uid','$targetURL',2)";       
		}else{
			$query_str = "INSERT INTO master_domain (master_id,domain,verified)VALUE('$uid','$targetURL',0)";  
		}
		$query_insert = $this->db->query($query_str);
        $domainState = mysql_query("SELECT count(*) as amount FROM domain  WHERE domain = '$targetURL'");
        $domainState = mysql_fetch_array($domainState);
        if($domainState['amount']==0){
          $data = array(
            'domain' => $targetURL,
            'time' => date('Y-m-d H:i:s')
          );
          $query_insert = $this->db->insert('domain', $data);
          $docName = 'user_css/'.$targetURL.'.css';		
          if(!file_exists($docName)){
            file_put_contents($docName, ' ');
          }	
        }
        $_SESSION["domain"] = $targetURL;				
      }
      return $targetURL;		  
    }
  }

  function checkURLDone(){
    $targetURL = $this->input->post('targetURL');
    $uid = $_SESSION["uid"];
    $pattern = '/^(https?|ftp|mms):\/\//';
    $targetURL = preg_replace($pattern,'',$targetURL);
    $pattern = '/\/$/';
    $targetURL = preg_replace($pattern,'',$targetURL);

    if($targetURL!=''&&$uid!=''){
      $state = "SELECT count(*) FROM master_domain WHERE master_domain.domain='$targetURL' AND master_domain.master_id = '$uid'";
      $state = mysql_query($state);
      $state = mysql_fetch_array($state);	  
      if($state[0]!=0){
          $query_str = "DELETE FROM master_domain WHERE master_id='$uid' AND domain='$targetURL'";
          $query_insert = $this->db->query($query_str);			
      }
      return true;		  
    }
  }



  /**
   * 网站主账号登陆
   */
  function userLogin(){
    $password = $_REQUEST['loginPassword']; 
    $remCheck = $_REQUEST['rem'];
    $email = $this->post_check(strtolower($_REQUEST['email']));
    $password = md5($password);
    $userObj = "SELECT *  FROM master WHERE master.email='$email' AND master.password ='$password' ";
    $userObj = mysql_query($userObj);
    $userArr = mysql_fetch_array($userObj);
    $userAmount = mysql_num_rows($userObj);
    if($userAmount!=0){
      $_SESSION['uid'] = $userArr['master_id'];
      if (!get_magic_quotes_gpc()) { $userArr['nick'] = stripslashes($userArr['nick']); }     
      $_SESSION['uname']= $userArr['nick'];
      if($remCheck==1){
        $time=time()+60*60*24*30;
        setcookie('auto_login' , 'true' , $time, '/');
        setcookie('login_email' , $email , $time, '/');
        setcookie('login_password' , $password , $time, '/');
      }else{
        $time=time()-60*60*24*30;
        setcookie('auto_login' , 'false' , $time, '/');
        setcookie('login_email' , $email , $time, '/');
        setcookie('login_password' , $password , $time, '/');
      }
      /*$data = array(
        'sso_name' => 'youyan',
        'id' => $userArr['master_id'],
        'username' => $userArr['nick'],
        'email' => $userArr['email'],
        'profile_img' => 'http://uyan.cc/images/TENCENTL.png',
      );
      echo json_encode($data);*/
      echo json_encode($userArr['nick']);
    }else{	 
      echo 'noData';
    }
  }

  /**
   * 网站主账号跨域登陆
   */
  function userLoginCrossDomain(){
    $password = trim($_REQUEST['loginPassword']); 
    $remCheck = $_REQUEST['rem'];
    $email = strtolower($_REQUEST['email']);
    $domain = $_REQUEST['domain'];
    $password = md5($password);
    $userObj = "SELECT *  FROM master WHERE master.email='$email' AND master.password ='$password' ";
    $userObj = mysql_query($userObj);
    $userArr = mysql_fetch_array($userObj);
    $userAmount = mysql_num_rows($userObj);
    if($userAmount!=0){
      $query = $this->db->query("select * from domain where domain='$domain'");
      $query_arr = $query->row_array();
      $query_arr['uid'] = $userArr['master_id'];
      $query_arr['uname'] = $userArr['nick'];

      if($remCheck==1){
        $time=time()+60*60*24*30;
        setcookie('auto_login' , 'true' , $time, '/');
        setcookie('login_email' , $email , $time, '/');
        setcookie('login_password' , $password , $time, '/');
      }else{
        $time=time()-60*60*24*30;
        setcookie('auto_login' , 'false' , $time, '/');
        setcookie('login_email' , $email , $time, '/');
        setcookie('login_password' , $password , $time, '/');
      }
      return $query_arr;
    }else{
      return 'noData';
    }
  }

  /**
   * 网站主账号自动登录（通过cookie,跨域)
   */
  function userAutoLoginCrossDomain(){
    $password = trim($_REQUEST['loginPassword']);
    $remCheck = $_REQUEST['rem'];
    $email = strtolower($_REQUEST['email']);
    $userObj = "SELECT *  FROM master WHERE master.email='$email' AND master.password ='$password' ";
    $domain = $_REQUEST['domain'];
    $userObj = mysql_query($userObj);
    $userArr = mysql_fetch_array($userObj);
    $userAmount = mysql_num_rows($userObj);
    if($userAmount!=0){
      $_SESSION['uid'] = $userArr['master_id'];
      $_SESSION['uname']= $userArr['nick'];
      if($remCheck==1){
        $time=time()+60*60*24*30;
        setcookie('auto_login' , 'true' , $time, '/');
        setcookie('login_email' , $email , $time, '/');
        setcookie('login_password' , $password , $time, '/');
      }else{
        $time=time()-60*60*24*30;
        setcookie('auto_login' , 'false' , $time, '/');
        setcookie('login_email' , $email , $time, '/');
        setcookie('login_password' , $password , $time, '/');
      }

      $query = $this->db->query("select * from domain where domain='$domain'");
      $query_arr = $query->row_array();
      $query_arr['uid'] = $userArr['master_id'];
      $query_arr['uname'] = $userArr['nick'];
      return $query_arr;
    }else{
      return 'noData';
    }
  }

  function isAutoLogin()
  {
    /*if (isset($_COOKIE['auto_login']))
    {
      if(isset($_COOKIE['login_email'])&&$_COOKIE['auto_login']==true){		
        $result = mysql_query("SELECT *  FROM master WHERE master.email='".$_COOKIE['login_email']."'" );
        $myrow = mysql_fetch_array($result);
        if($myrow['password'] == $_COOKIE['login_password']){
          $_SESSION['uid'] = $myrow['master_id'];
          $_SESSION['uname'] = $myrow['nick'];
        }
      }
    }*/
    return false;
  }


  function userLogout()
  {
    //session_start();
    session_unset();
    session_destroy();
    $time=time()-60*60*24*30;
    setcookie('auto_login' , 'false' , $time, '/');
    setcookie('login_email' , '' , $time, '/');
    setcookie('login_password' , '' , $time, '/');
    return 1;
  }

  /**
   * 根据某domain，获取此domain的全部信息
   */
  function userDomain(){
    $domain = $this->input->post('domain');
    $_SESSION['showDomain'] = $domain;
    $sql = "select * from domain where domain='$domain'";
    $query = $this->db->query($sql);
    $row = $query->row_array();
    $_SESSION['domain_data'] = $row;
    return $domain;
  }

  function userCheckDomain(){
    $domain = $this->input->post('domain');
    $_SESSION['showDomain'] = $domain;
    $sql = "select * from domain where domain='$domain'";
    $query = $this->db->query($sql);
    $row = $query->row_array();
    $_SESSION['domain_data'] = $row;
    return $domain;
  }

  /**
   * 删除网站
   */
  function delDomain(){
    //session_start();
    $domain = $this->input->post('delURL');
    $userId = $_SESSION['uid'];
    $state = "SELECT count(*) FROM master_domain WHERE master_id='$userId' AND domain = '$domain'";
    $state = mysql_query($state);
    $state = mysql_fetch_array($state);	
    if($state[0]!=0){	
      mysql_query("DELETE FROM master_domain WHERE master_id='$userId' AND domain = '$domain'");	
    }
    return $domain;
  }

  /**
   * 获取用户（评论者）信息
   */
  function getUserProfile(){
  	  $user_id = $this->input->post('uid');
	  $from_num = $this->input->post('profileItemNum');
	  
	  $key = 'UserProfile_' . $user_id;
	  $result = $this->mem->get($key);
	  
	  if($result !== false) {
	  	$data = $result;
	  } else {
		$start_num = 20*$from_num;
		$query_str = "SELECT * FROM user 
							  LEFT JOIN comment ON user.user_id = comment.user_id
							  WHERE user.user_id='$user_id' ORDER BY comment.time DESC LIMIT ".$start_num.",20";
		$query = $this->db->query($query_str);
		$data = $query->result();
		$this->mem->set($key, $data, 3600);
	  }
	  return $data;
	  
  	
  	  // OLD
	  $user_id = $this->input->post('uid');
	  $from_num = $this->input->post('profileItemNum');
	  $start_num = 20*$from_num;
      $query_str = "SELECT * FROM user 
							  LEFT JOIN comment ON user.user_id = comment.user_id							  
							  WHERE user.user_id='$user_id' ORDER BY comment.time DESC LIMIT ".$start_num.",20";
      $query = $this->db->query($query_str);
      return $query->result();
  }

  function getTargetUserProfile($user_id){
      $query_str = mysql_query("SELECT * FROM user WHERE user_id='$user_id'");
      $query =  mysql_fetch_array($query_str);
      return $query;
  }


/**
 * 获取网站的活跃用户
 */
  function getUserProfileSocial(){
	  $user_id = $this->input->post('uid');
	  $from_num = $this->input->post('profileSocialNum');
	  
  	  $key = 'UserProfileSocial_' . $user_id;
	  $result = $this->mem->get($key);
	  
	  if($result !== false) {
	  	$data = $result;
	  } else {
		$start_num = 20*$from_num;
	    $query_str = "SELECT * FROM domain_user
								  LEFT JOIN domain ON domain.domain = domain_user.domain
								  WHERE domain_user.user_id='$user_id' ORDER BY domain_user.n_comments DESC LIMIT ".$start_num.",20";
	    $data = $this->db->query($query_str);
	    $this->mem->set($key, $data, 3600);
	  }
	  return $data;
  	
  	
	  // OLD
	  $user_id = $this->input->post('uid');
	  $from_num = $this->input->post('profileSocialNum');
	  $start_num = 20*$from_num;
      $query_str = "SELECT * FROM domain_user
							  LEFT JOIN domain ON domain.domain = domain_user.domain	  
							  WHERE domain_user.user_id='$user_id' ORDER BY domain_user.n_comments DESC LIMIT ".$start_num.",20";
      $query = $this->db->query($query_str);
      return $query->result();
  }

  function checkDomainFile(){
	  $user_id = $this->input->post('uid');
	  $domain = $this->input->post('curDomain');
	  $documentNamePathA = 'http://'.$domain.'/'.md5($user_id).'.html';
	  $documentNamePathB = 'http://'.$domain.'/'.md5($user_id).'.zip';
	  $documentNamePathC = 'https://'.$domain.'/'.md5($user_id).'.html';
	  $documentNamePathD = 'https://'.$domain.'/'.md5($user_id).'.zip';
	  $process = 'no';
	  if($this->url_exists($documentNamePathA)==1)$process ='yes';
	  if($this->url_exists($documentNamePathB)==1)$process ='yes';
/*	  if($this->url_exists($documentNamePathC)==1)$process ='yes';
	  if($this->url_exists($documentNamePathD)==1)$process ='yes';  */
	  if($process =='yes'){
		mysql_query("UPDATE master_domain SET verified = 2 WHERE domain = '$domain'"); 
		mysql_query("UPDATE master_domain SET verified = 1 WHERE domain ='$domain' AND master_id ='$user_id'");
	  }
	  return $process;
  }


  function setEmail(){
	  $email = $this->input->post('email');
	  $email = $this->post_check($email);
	  $user_id = $this->input->post('user_id');	  
	  mysql_query("UPDATE user SET email = '$email' WHERE user_id= '$user_id'");
	  return 1;
  }

  function userData(){
	  $user_id = $this->input->post('user_id');
	  $userData = mysql_query("SELECT * FROM user WHERE user_id ='$user_id'");
	  $userData = mysql_fetch_array($userData);
	  return $userData;
  }

  function setTitle(){
	  $title = $this->input->post('title');
	  $title = $this->post_check($title);
	  $user_id = $this->input->post('user_id');
	  mysql_query("UPDATE user SET show_title = '$title' WHERE user_id= '$user_id'");
	  return 1;	  
  }

  function getTargetUserWebsite($uid){
	  if($uid!=''){
 		$query_str = "SELECT * FROM domain_user WHERE user_id = '$uid' ORDER BY n_comments DESC LIMIT 0,5";
      	$query = $this->db->query($query_str);
     	return $query->result();
	  }
  }

  function resetPasswordDone(){
	  $email = $this->input->post('email');
	  $email = $this->post_check($email);
	  $password = $this->input->post('password');
	  $password = md5($password);
	  if($password=='')return 0;
	  mysql_query("UPDATE master SET password = '$password' WHERE email= '$email'");
	  $uid = mysql_query("SELECT * FROM master WHERE email = '$email'");
	  $uid = mysql_fetch_array($uid);
	  $uid = $uid['master_id'];
	  mysql_query("DELETE FROM getpw WHERE uid= '$uid'");
	  return 1;
  }

  function resetPassword(){
	  $email = $this->input->post('email');
	  $email = $this->post_check($email);
	  $master_obj = mysql_query("SELECT * FROM master WHERE email = '$email'");
	  $msater_amount = mysql_num_rows($master_obj);
	  if($msater_amount==0)return 'no';
	  $master_obj = mysql_fetch_array($master_obj);
	  $master_id = $master_obj['master_id'];
	  $master_name = $master_obj['nick']; 
	  if($master_name==''){$master_name='先生/女士';}
	  $checkcombinestr = time().$master_id;
	  $checkcombine = md5($checkcombinestr);
	  $date = date('Y-m-d H:i:s');
	  mysql_query("INSERT INTO getpw (uid,checkcombine,ts_created)VALUE('$master_id','$checkcombine','$date')");
$content = '<body>
<title>重设密码</title>
<style>
#linkdiv a{	
	color: rgb(64, 63, 58); 
}
#linkdiv a:visited{
	color:#403f3a;
}
#linkdiv a:hover{
	color:#2a82d4;
}
</style>
<div style="height: 130px; margin-left: auto; margin-right: auto; padding-top: 30px;">
<div style="height: 90px; font-size: 12px; line-height: 15px;">
<span style="border-bottom: 1px solid rgb(204, 204, 204); display: block; color: rgb(142, 142, 142); height: 25px; font-weight: bold; font-size: 14px;">Hi '.$master_name.',</span>
<span style="display: block; padding-top: 8px; height:19px; font-weight:bold;">请点击下面链接重设您在友言网密码</span>
<a style="height:18px;border-bottom: 1px solid rgb(204, 204, 204); display: block; padding-bottom: 8px;" href="http://uyan.cc/getpwd/reset/'.$checkcombine.'">http://uyan.cc/getpwd/reset/'.$checkcombine.'</a></div>
<div style="height: 20px; clear: both;">
<span style="display: block; font-size: 14px; font-weight: bold; color: rgb(233, 81, 148);">如果您并没有注册友言或者并非此信件的接收者，请删除此封邮件，对您造成的不便表示歉意。</span>
<span style="display: block; font-size: 12px; font-weight: 100; color: rgb(38, 38, 38);">如果您仍旧无法修改密码请咨询管理员 help@uyan.cc</span>
</div>
</div>';
	  $subject = '请重新设置您在友言网的密码';
	  $this->smtp_pw_mail($email,$master_name,$content,$subject);
	  return 'yes';
  }

  function url_exists($url) {
        $head=get_headers($url);
		$state = stripos($head[0],'OK');
        if(is_bool($state)) {
                return 0;
        }
        return 1; 
  }

  function sql_injection($content){
    if (!get_magic_quotes_gpc()) { 
      if (is_array($content)) { 
        foreach ($content as $key=>$value) { 
          $content[$key] = addslashes($value); 
        } 
      } else { 
        addslashes($content); 
      } 
    }
    return $content; 
  }

  # /*  
  # 函数名称：inject_check()  
  # 函数作用：检测提交的值是不是含有SQL注射的字符，防止注射，保护服务器安全  
  # 参　　数：$sql_str: 提交的变量  
  # 返 回 值：返回检测结果，ture or false  
  # */    
  function inject_check($sql_str) {     
    return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    
  }
  # /*  
  # 函数名称：verify_id()  
  # 函数作用：校验提交的ID类值是否合法  
  # 参　　数：$id: 提交的ID值  
  # 返 回 值：返回处理后的ID  
  # */    
  function verify_id($id=null) {     
    if (!$id) { exit('没有提交参数！'); }    // 是否为空判断     
    elseif (inject_check($id)) { exit('提交的参数非法！'); }    // 注射判断     
    elseif (!is_numeric($id)) { exit('提交的参数非法！'); }    // 数字判断     
      $id = intval($id);    // 整型化     
    return  $id;     
  }
  # /*  
  # 函数名称：str_check()  
  # 函数作用：对提交的字符串进行过滤  
  # 参　　数：$var: 要处理的字符串  
  # 返 回 值：返回过滤后的字符串  
  # */    
  function str_check( $str ) {     
    if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否打开     
      $str = addslashes($str);    // 进行过滤     
    }     
    $str = str_replace("_", "\_", $str);    // 把 '_'过滤掉     
    $str = str_replace("%", "\%", $str);    // 把 '%'过滤掉     

    return $str; 
  }
  # /*  
  # 函数名称：post_check()  
  # 函数作用：对提交的编辑内容进行处理  
  # 参　　数：$post: 要提交的内容  
  # 返 回 值：$post: 返回过滤后的内容  
  # */    
  function post_check($post) {     
    if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否为打开     
      $post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤     
    }     
    $post = str_replace("_", "\_", $post);    // 把 '_'过滤掉     
    $post = str_replace("%", "\%", $post);    // 把 '%'过滤掉     
    $post = nl2br($post);    // 回车转换     
    $post = htmlspecialchars($post);    // html标记转换     

    return $post;     
  }
  	function smtp_pw_mail($sendto_email, $user_name,$content,$subject){
		require_once("phpmailer/class.phpmailer.php");
		$body = $content;
		$mail = new PHPMailer(); 
		$mail->IsSMTP(); // send via SMTP 	
		$mail->CharSet = "UTF-8";
		//$mail->Encoding = "base64";	
		$mail->Host = "127.0.0.1"; // SMTP servers 
		$mail->Port = 25; 
		$mail->SMTPAuth = false; // turn on SMTP authentication 
		$mail->Username = "root"; // SMTP username
		$mail->Password = "youyan"; // SMTP password 
		$mail->From = 'admin@uyan.cc'; // 发件人邮箱
		$mail->FromName = '友言客服'; // 发件人
		$mail->AddAddress($sendto_email,$user_name); // 收件人邮箱和姓名
		$mail->AddReplyTo("admin","uyan.cc");
		$mail->IsHTML(true); // send as HTML
		// 邮件主题
		$mail->Subject = htmlspecialchars($subject); 
		// 邮件内容
		$mail->Body = $body;
		$mail->AltBody ="text/html";
		if(!$mail->Send()){ 
			return 0;
		}else{ 
			return 1; 
		}
	} 
}

