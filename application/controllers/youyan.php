<?php
require_once(APPPATH."inc/config.php");


class YouYan extends CI_Controller {

  /**
   * 取IP地址
   */
  function getIP(){
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')){
      $ip = getenv('HTTP_CLIENT_IP');
    }
    elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')){
      $ip = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')){
      $ip = getenv('REMOTE_ADDR');
    }
    elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')){
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : 'unknown';
  }

  /**
   * 没有使用，判断某文件是否存在
   */
  function remote_file_exist($url){
    $header_array = get_headers ( $url );  
    if ($header_array [0] == 'HTTP/1.1 200 OK') {  
      return true;
    } else {  
      return false;
    }   
  }

  function __construct(){
    parent::__construct();
  }


  /**
   * 获取用户profile
   */
  function profile(){
    $data['main_content'] = 'youyan_profile_view';	  			
    $this->load->model('comment_model');
    $query_result = $this->comment_model->getCommentsByUser(1);
    $data['query_result'] = $query_result;
    $this->load->view('include/template',$data);
  }



  /**
   * 程序入口
   */
  function index(){
    $master_id = $_GET['master_id'];
    $domain = $_GET['domain'];
    $page = $_GET['pageId'];
	$domain = $this->post_check_domain($domain);
    $session_name = 'uyan_' . $domain;
    $data['session_name'] = $session_name;	// 存储页面配置信息


    // 验证页面
    $flag_good_page = $this->verifyPage();

    if(!isset($_SESSION[$session_name])){
      $configure_data = array();
      if($this->verifyDomain($master_id, $domain, $configure_data) == 0){
        echo '嵌入评论框代码有错, 站长ID无效';
        return;
      }

      /**
       * If user has already logged (data kept in the session), just open the 
       * loggedin_view
       */
      $_SESSION[$session_name] = $configure_data;
      //var_dump($_SESSION[$session_name]);
    }

    $inc = 1;
    $this->load->view('youyan_basic_view', $data);

    /*
     * 统计信息
     */
    $this->db->set('count', "count+$inc", false);
    $this->db->where('page', 'youyan_comment_box')->update('page_view');

    $date = date("Y-m-d");
    $this->db->where('date', $date)->from('date_view');
    $count = $this->db->count_all_results();
    if($count == 0){
      $data = array('date' => $date, 'view' => 1);
      $this->db->insert('date_view', $data);
    }
    else{
      $this->db->where('date', $date)->set('view', 'view'."+$inc", false);
      $this->db->update('date_view');
    }


    if($flag_good_page == -1)
      return;


    $this->db->where('domain', $domain)->where('date', $date)->from('domain_date_view');
    $count = $this->db->count_all_results();
    if($count == 0){
      $data = array('domain' => $domain, 'date' => $date, 'view' => 1);
      $this->db->insert('domain_date_view', $data);
    }
    else{
      $this->db->where('domain', $domain)->where('date', $date)->set('view', 'view'."+$inc", false);
      $this->db->update('domain_date_view');
    }

    $this->db->where('page', $page)->from('page_date_view');
    $count = $this->db->count_all_results();
    if($count == 0){
      $data = array('page' => $page, 'date' => $date, 'view' => 1);
      $this->db->insert('page_date_view', $data);
    }
    else{
      $this->db->where('page', $page)->where('date', $date)->set('view', 'view'."+$inc", false);
      $this->db->update('page_date_view');
    }
  }


  function logout(){
    unset($_SESSION['login']);
    if(isset($_COOKIE['uyan_login_cookie'])){
      setcookie('uyan_login_cookie');
    }
  }



  /**
   * 登陆的入口
   */
  function prepareLogin($type){
    $data = array();
    switch($type){
    case 'sina':
      $_SESSION['sina_callback_type'] = 'login';
      $sina_o = new WeiboOAuth( SINA_AKEY , SINA_SKEY  );
      $keys = $sina_o->getRequestToken();
      $_SESSION['sina_request_token'] = $keys;
      $sina_aurl = $sina_o->getAuthorizeURL($keys['oauth_token'] ,false , SINA_CALLBACK);
      $data['aurl'] = $sina_aurl;
      break;

    case 'renren':
      $renren_o = new RenrenOauth; 
      $renren_aurl = $renren_o->getAuthorizeUrl();
      //echo $renren_aurl;
      $data['aurl'] = $renren_aurl;
      $_SESSION['renren_callback_type'] = 'login';
      break;

    case 'kaixin':
      $connection = new KXClient(KAIXIN_CONSUMER_KEY, KAIXIN_CONSUMER_SECRET);
      $request_token_ret = $connection->getRequestToken('http://uyan.cc/index.php/kaixin_callback', 'create_records');

      $request_token = $request_token_ret['response'];
      $url = $connection->getAuthorizeURL($request_token);
      $kaixin_aurl = $url['response']; 

      $_SESSION['kaixin_request_token'] = $request_token;
      $_SESSION['kaixin_callback_type'] = 'login';
      $data['aurl'] = $kaixin_aurl;
      break;

    case 'sohu':
      $oauth = new SohuOAuth(SOHU_CONSUMER_KEY, SOHU_CONSUMER_SECRET);
      /* 获取request token */
      $request_token = $oauth->getRequestToken(SOHU_OAUTH_CALLBACK);

      $token = $request_token['oauth_token'];
      $url = $oauth->getAuthorizeUrl1($token, SOHU_OAUTH_CALLBACK);

      /* 保存request token，成功获取access token之后用access token代替 */
      $_SESSION['sohu_request_token'] = $request_token;
      $_SESSION['sohu_callback_type'] = 'login';
      $data['aurl'] = $url;
      break;

    case 'neteasy':
      $oauth = new NEOAuth(NETEASY_WB_AKEY, NETEASY_WB_SKEY);
      /* 获取request token */
      $request_token = $oauth->getRequestToken();
      $token = $request_token['oauth_token'];

      $url = $oauth->getAuthorizeURL($token, NETEASY_OAUTH_CALLBACK);


      /* 保存request token，成功获取access token之后用access token代替 */
      $_SESSION['neteasy_request_token'] = $request_token;
      $_SESSION['neteasy_callback_type'] = 'login';
      $data['aurl'] = $url;
      break;

    case 'tencent':
      $oauth = new MBOpenTOAuth( TENCENT_AKEY , TENCENT_SKEY  );
      /* 获取request token */
      $request_token = $oauth->getRequestToken(TENCENT_CALLBACK);
      $url = $oauth->getAuthorizeURL( $request_token['oauth_token'] ,false,'');

      /* 保存request token，成功获取access token之后用access token代替 */
      $_SESSION['tencent_request_token'] = $request_token;
      $_SESSION['tencent_callback_type'] = 'login';
      $data['aurl'] = $url;
      break;

    case 'qq':
      $_SESSION['qq_callback_type'] = 'login';
      redirect_to_login(QQ_APPID, QQ_APPKEY, QQ_CALLBACK);
      return;

    case 'msn':
      $_SESSION['msn_callback_type'] = 'login';
      header("location: " . ENDPOINT_OAUTH . ENDPOINT_PATH_AUTHORIZE .
    PARAM_CLIENT_ID . APP_CLIENT_ID .
    PARAM_SCOPE . REQUESTED_SCOPES .
    PARAM_RESPONSE_TYPE . PARAM_RESPONSE_TYPE_CODE .
    PARAM_REDIRECT_URI . APP_REDIRECT_URI);
      return;

    case 'sso':
      $this->load->view('youyan_sso_view.php');
      return;
    }

    #echo $data['aurl'];
    header("location: ". $data['aurl']);
  }



  /**
   * This is the response function of the bind() ajax call from youyan_basic_view.js,
   * it will pass back the related information for the view to do update.
   *
   * NOT USED
   */
  function bind($type, $user_id){
    $data = array();
    switch ($type){
    case 'sina':
      $_SESSION['sina_callback_type'] = 'bind';
      $sina_o = new WeiboOAuth( SINA_AKEY , SINA_SKEY  );
      $keys = $sina_o->getRequestToken();
      $_SESSION['sina_request_token'] = $keys;

      $sina_aurl = $sina_o->getAuthorizeURL($keys['oauth_token'] ,false , SINA_CALLBACK);
      $data['bind_aurl'] = $sina_aurl;
      break;
    case 'renren':
      $_SESSION['renren_callback_type'] = 'bind';
      $renren_o = new RenrenOauth; 
      $renren_aurl = $renren_o->getAuthorizeUrl();
      $data['bind_aurl'] = $renren_aurl;
      break;
    case 'kaixin':
      $kaixin_o = new KXClient(KAIXIN_CONSUMER_KEY, KAIXIN_CONSUMER_SECRET);
      $request_token_ret = $kaixin_o->getRequestToken('http://uyan.cc/index.php/kaixin_callback', 'create_records');
      $request_token = $request_token_ret['response'];

      $_SESSION['kaixin_request_token'] = $request_token;
      $_SESSION['kaixin_callback_type'] = 'bind';
      $url_wrapper = $kaixin_o->getAuthorizeURL($request_token);
      $kaixin_aurl = $url_wrapper['response']; 

      $data['bind_aurl'] = $kaixin_aurl;
      break; 
    case 'sohu':
      $_SESSION['sohu_callback_type'] = 'bind';
      $oauth = new SohuOAuth(SOHU_CONSUMER_KEY, SOHU_CONSUMER_SECRET);

      $request_token = $oauth->getRequestToken(SOHU_OAUTH_CALLBACK);
      $_SESSION['sohu_request_token'] = $request_token;
      $token = $request_token['oauth_token'];
      $url = $oauth->getAuthorizeUrl1($token, SOHU_OAUTH_CALLBACK);
      //var_dump($url);

      $data['bind_aurl'] = $url;
      break; 
    case 'neteasy':
      $_SESSION['neteasy_callback_type'] = 'bind';
      $oauth = new OAuth(NETEASY_WB_AKEY, NETEASY_WB_SKEY);
      $request_token = $oauth->getRequestToken();
      $token = $request_token['oauth_token'];
      $_SESSION['neteasy_request_token'] = $request_token;
      $url = $oauth->getAuthorizeURL($token, NETEASY_OAUTH_CALLBACK);
      //var_dump($url);

      $data['bind_aurl'] = $url;
      break; 
    case 'tencent':
      $oauth = new MBOpenTOAuth( TENCENT_AKEY , TENCENT_SKEY  );
      /* 获取request token */
      $request_token = $oauth->getRequestToken(TENCENT_CALLBACK);
      $url = $oauth->getAuthorizeURL( $request_token['oauth_token'] ,false,'');

      /* 保存request token，成功获取access token之后用access token代替 */
      $_SESSION['tencent_request_token'] = $request_token;
      $_SESSION['tencent_callback_type'] = 'bind';
      $data['aurl'] = $url;

      $data['bind_aurl'] = $url;
      break; 
    }
    $this->load->view('youyan_bind_view', $data);
  }


  /**
   * This is the function used sololy for user creation of the uyan account. 
   * NOT USED
   */
  function createUser($action = 'signup'){
    $this->load->model('user_model');

    $user_name = $this->input->post('user_name');
    $email = $this->input->post('email');
    $password = md5($this->input->post('password'), false);

    if($this->user_model->user_exist('user_name', $user_name))
      echo 'user_name: '.$user_name;
    else if($this->user_model->user_exist('email', $email))
      echo "email: ".$email;

    else{
      /*$bindType = $_SESSION['candidata_bind_type'];
      $bindTypeId = $_SESSION['candidata_bind_data'][$bindType."_id"];
      if($this->user_model->user_exist($bindType.'_id', $bindTypeId){

      }*/

      $metadata = array(
        'user_name' => $user_name,
        'email' => $email,
        'password' => $password
      );

      if($action == 'signup'){
        $query_result = $this->user_model->create_user('youyan', $metadata);
      }
      else if ($action == 'bind'){
        $metadata = array_merge($metadata, $_SESSION['candidate_bind_data']);
        $query_result = $this->user_model->create_user($_SESSION['candidate_bind_type'], $metadata);
      }
      $_SESSION['login'] = $this->user_model->get_binded_accounts($query_result);
      echo json_encode($_SESSION['login']);
    }
  }



  /**
   * Log in function when the user log in with user_name or email
   *
   * NOT USED
   */
  function login($is_binding = false){
    $this->load->model('user_model');
    $query_result = $this->user_model->login(true, $is_binding);

    if($query_result == false)
      echo json_encode(array('result' => 'false'));
    else{
      $_SESSION['login'] = $this->user_model->get_binded_accounts($query_result);
      echo json_encode($_SESSION['login']);
    }
  }
  /**
   * check or send comment alert email to master
   *
   * NOT USED
   */
  function commentEmail(){
    $this->load->model('comment_model');
    echo $this->comment_model->commentEmail();
  }

  /**
   * Check if the domain is verified, if the user_id doesn't exsit, return 0;
   * Otherwise, if the user_id--domain pair do not exsit, put in the 
   * correlation.
   * Otherwise, the correlation exsit, but it's not verified, set it to be 1
   * 验证域名（网站）
   */
  function verifyDomain($master_id, $domain, &$configure_data){
	$domain = $this->post_check_domain($domain);
    $this->db->where('master_id', $master_id)->from('master');
    if($this->db->count_all_results() == 0){
      return 0;
    }
	if($master_id==''){
		return 0;	
	}
	if($master_id==0||$master_id=='0'||$master_id=='10'||$master_id==10){
		$query_domain = $this->db->where('domain', $domain)->get('domain');
		$query_result = $query_domain->row_array();
		$configure_data = $query_result;	
		return 1;
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
		$verifyTCheck = mysql_query("SELECT count(*) FROM master_domain WHERE domain='$domain' AND master_id='$master_id'");
		$verifyTCheck = mysql_fetch_array($verifyTCheck);
		if($verifyTCheck[0]>=1){			
			mysql_query("UPDATE master_domain SET verified=2 WHERE domain='$domain' AND master_id='$master_id'");
		}else{
			mysql_query("INSERT INTO master_domain (domain,master_id)VALUE('$domain','$master_id')");
		}
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
		$docNameComment = 'user_css/comment/'.$domain.'.css';
        if(!file_exists($docNameComment)){
          file_put_contents($docNameComment, ' ');
        }		
		$docNameArticle = 'user_css/article/'.$domain.'.css';
        if(!file_exists($docNameArticle)){
          file_put_contents($docNameArticle, ' ');
        }	
        $docName = 'spam_words/'.$domain.'.txt';		        // Prepare for the spam words files
        if(!file_exists($docName)){
          copy('spam_words/template.txt', $docName);
        }		
        $new_domain = 1;
      }
    }

    $query_domain = $this->db->where('domain', $domain)->get('domain');
    $query_result = $query_domain->row_array();
    $configure_data = $query_result;

    var_dump($configure_data);
    return 1;
  }


  /**
   * 验证页面
   */
  function verifyPage(){
    $this->db->where('page', $_GET['pageId'])->from('page');
    $count = $this->db->count_all_results();
	
    if($count == 0){
      $page_url = $this->post_check_domain($_GET['url']);
      if(strpos($page_url, '&amp;preview') != false){
        return -1;
      }
      $page_title = $this->post_check_domain($_GET['title']);
      $domain = $this->post_check_domain($_GET['domain']);

      $data_page = array(
        'domain' => $domain,
        'page' => $_GET['pageId'],
        'page_url' => $page_url,
        'page_title' => $page_title,
        'time' => date('Y-m-d H:i:s')
      );
      $this->db->insert('page', $data_page);
      
      //upate user amount 
	  $str_user = mysql_query("SELECT GROUP_CONCAT(user_id) FROM domain_user WHERE domain = '$domain' GROUP BY domain");	  
	  $str_user = mysql_fetch_array($str_user);
	  $long_str = $str_user[0];
	  mysql_query("UPDATE domain_user SET unread =unread+1 WHERE FIND_IN_SET(user_id,'$long_str')>=1 AND domain = '$domain'");
      mysql_query("UPDATE user SET noti_article =noti_article+1 WHERE FIND_IN_SET(user_id,'$long_str')>=1");
      return 0;
    }
  }

  function getSinaShortURL($longURL){
    $url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=507593302&url_long=' . $longURL;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $output_json = json_decode($output);
    $short_url =  $output_json[0]->url_short;
    echo $short_url;
    return $short_url;
  }
  
  /**
   * 防止注入攻击
   */
  function post_check_domain($post) {     
    if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否为打开     
      $post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤     
    }     
    $post = nl2br($post);    // 回车转换     
    $post = htmlspecialchars($post);    // html标记转换
    return $post;     
  }
}
