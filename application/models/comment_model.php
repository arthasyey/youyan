<?php
require_once(APPPATH."inc/config.php");
require_once(APPPATH.'sdk/qq/share/add_share.php');


class Comment_Model extends CI_Model {


  /**
   * page部分的结构是"domain_url"
   */
  function build_page_part($domain, $url){
    $pos = strpos($url, 'http');
    if($pos != -1){
      $url = substr($url, $pos + 7);
    }
    $page = $domain . "_" . $url;
    return $page;
  }

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

  function export_wp_comments(){
    $ret_comments = array();
    $url_base = $_POST['url_base'];
    $domain = $_POST['domain'];
    $page_like = $domain . "_" . substr($url_base, 7);

    $sql = "select * from comment, user where comment.user_id = user.user_id and comment.page like '$page_like%' and comment.reply_to_comment_id=0 and comment.wp_import_export_id=0";
    $query = $this->db->query($sql);

    $query_results = $query->result_array();
    foreach($query_results as $parent_comment){
      $comments_group = array();
      $comments_group[] = $parent_comment;
      $parent_comment_id = $parent_comment['comment_id'];
      $sql_child = "select * from comment, user where comment.user_id = user.user_id and comment.page like '$page_like%' and comment.reply_to_comment_id=$parent_comment_id and comment.wp_import_export_id=0";
      $child_query = $this->db->query($sql_child);

      $child_query_results = $child_query->result_array();

      foreach($child_query_results as $child_comment){
        $comments_group[] = $child_comment;
      }
      $ret_comments[] = $comments_group;
    }

    $ret = $this->db->like('page', $page_like, 'after')->where('from_type !=', 'wordpress')->set('wp_import_export_id', '-1')->update('comment');
    echo json_encode($ret_comments);
  }

  function import_wp_comments(){
    $parent_comment = json_decode($_POST['parent_comment'], true);
    //var_dump($parent_comment);
    $descentdants = json_decode($_POST['descentdants'], true);
    $url_base = $_POST['url_base'];
    $domain = $_POST['domain'];

    $num_new_comments = 0;

    if($url_base[strlen($url_base)-1] != '/')
      $url_base .= '/';
    $page_url = $url_base . "?p=" . $parent_comment['comment_post_ID'];
    $page = $this->build_page_part($domain, $page_url);

    $this->db->where('wp_import_export_id', $parent_comment['comment_ID'])->where('page', $page)->from('comment');
    $count = $this->db->count_all_results();

    if($count == 0){
echo 'new comment: ';
      $data = array(
        'from_type' => 'wordpress',
        'page_url' => $page_url,
        'domain' => $domain, 
        'page' => $page,
        'user_id' => 94,                             // Super Wordpress User
        'content' => $parent_comment['comment_content'],
        'time' => $parent_comment['comment_date'],
        'comment_author' => $parent_comment['comment_author'],
        'comment_author_email' => $parent_comment['comment_author_email'],
        'comment_author_url' => $parent_comment['comment_author_url'],
        'IP' => $parent_comment['comment_author_IP'],
        'wp_import_export_id' => $parent_comment['comment_ID']
      );
var_dump($data);
      $this->db->insert('comment', $data);
      $comment_id = $this->db->insert_id();
echo $comment_id;
      $num_new_comments++;
    }
    else{
      $comment_id = $parent_comment['comment_ID'];
    }
    $data['reply_to_comment_id'] = $comment_id;
    /*foreach($descentdants as $descentdant){
      $this->db->where('wp_import_export_id', $descentdant->comment_ID)->where('page', $page)->from('comment');
      if($this->db->count_all_results() == 0){

        $data['wp_import_export_id'] = $descentdant->comment_ID;
        $data['IP'] = $descentdant->comment_author_IP;
        $data['comment_author'] = $descentdant->comment_author;
        $data['comment_author_url'] = $descentdant->comment_author_url;
        $data['comment_author_email'] = $descentdant->comment_author_email;
        $data['content'] = $descentdant->comment_content;
        $data['time'] = $descentdant->comment_date;
        $this->db->insert('comment', $data);

        $num_new_comments++;
      }
    }*/

    /* update the page table */
    $this->db->where('page', $page)->from('page');
    $num_page_listed = $this->db->count_all_results();

    if($num_page_listed == 0){
      $insert_data = array(
        'page' => $page,
        'page_url' => $page_url, 
        'n_comments' => $num_new_comments,
        'n_comments_all' => $num_new_comments,
        'n_wordpress_comments' => $num_new_comments
      );
      $this->db->insert('page', $insert_data);
    }
    else{
      $this->db->where('page', $page);
      $ret = $this->db->set('n_comments', 'n_comments+'.$num_new_comments, false)->set('n_comments_all', 'n_comments_all+'.$num_new_comments, false)->set('n_wordpress_comments', 'n_wordpress_comments+'.$num_new_comments, false)->update('page');
    }

    $this->db->where('domain', $domain)->from('domain');
    $num_domain_listed = $this->db->count_all_results();
    if($num_domain_listed == 0){
      $insert_data = array(
        'domain' => $domain,
        'n_comments' => $num_new_comments,
        'n_comments_all' => $num_new_comments,
        'n_wordpress_comments' => $num_new_comments
      );
      $this->db->insert('domain', $insert_data);
    }
    else{
      $this->db->where('domain', $domain);
      $ret = $this->db->set('n_comments', 'n_comments+'.$num_new_comments, false)->set('n_comments_all', 'n_comments_all+'.$num_new_comments, false)->set('n_wordpress_comments', 'n_wordpress_comments+'.$num_new_comments, false)->update('domain');
    }
  }
  
  function import_wp_to_uyan_comments(){
  	$parent_comment = json_decode($_POST['parent_comment'], true);
  	$descentdants = json_decode($_POST['descentdants'], true);
  	$url_base = $_POST['url_base'];
  	$domain = $_POST['domain'];
  
  	$num_new_comments = 0;
  
  	if($url_base[strlen($url_base)-1] != '/')
  		$url_base .= '/';
  	$page_url = $url_base . "?p=" . $parent_comment['comment_post_ID'];
  	$page = $this->build_page_part($domain, $page_url);
  
  	$this->db->where('wp_import_export_id', $parent_comment['comment_ID'])->where('page', $page)->from('comment');
  	$count = $this->db->count_all_results();
  
  	if($count == 0){
  		//echo 'new comment: ';
  		$data = array(
  				'from_type' => 'wordpress',
  				'page_url' => $page_url,
  				'domain' => $domain,
  				'page' => $page,
  				'user_id' => 94,                             // Super Wordpress User
  				'content' => $parent_comment['comment_content'],
  				'time' => $parent_comment['comment_date'],
  				'comment_author' => $parent_comment['comment_author'],
  				'comment_author_email' => $parent_comment['comment_author_email'],
  				'comment_author_url' => $parent_comment['comment_author_url'],
  				'IP' => $parent_comment['comment_author_IP'],
  				'wp_import_export_id' => $parent_comment['comment_ID']
  		);
  		//var_dump($data);
  		$this->db->insert('comment', $data);
  		$comment_id = $this->db->insert_id();
  		//echo $comment_id;
  		$num_new_comments++;
  	}
  	else{
  		$comment_id = $parent_comment['comment_ID'];
  	}
  	$data['reply_to_comment_id'] = $comment_id;
  	/*foreach($descentdants as $descentdant){
  	 $this->db->where('wp_import_export_id', $descentdant->comment_ID)->where('page', $page)->from('comment');
  	if($this->db->count_all_results() == 0){
  
  	$data['wp_import_export_id'] = $descentdant->comment_ID;
  	$data['IP'] = $descentdant->comment_author_IP;
  	$data['comment_author'] = $descentdant->comment_author;
  	$data['comment_author_url'] = $descentdant->comment_author_url;
  	$data['comment_author_email'] = $descentdant->comment_author_email;
  	$data['content'] = $descentdant->comment_content;
  	$data['time'] = $descentdant->comment_date;
  	$this->db->insert('comment', $data);
  
  	$num_new_comments++;
  	}
  	}*/
  
  	/* update the page table */
  	$this->db->where('page', $page)->from('page');
  	$num_page_listed = $this->db->count_all_results();
  
  	if($num_page_listed == 0){
  		$insert_data = array(
  				'page' => $page,
  				'page_url' => $page_url,
  				'n_comments' => $num_new_comments,
  				'n_comments_all' => $num_new_comments,
  				'n_wordpress_comments' => $num_new_comments
  		);
  		$this->db->insert('page', $insert_data);
  	}
  	else{
  		$this->db->where('page', $page);
  		$ret = $this->db->set('n_comments', 'n_comments+'.$num_new_comments, false)->set('n_comments_all', 'n_comments_all+'.$num_new_comments, false)->set('n_wordpress_comments', 'n_wordpress_comments+'.$num_new_comments, false)->update('page');
  	}
  
  	$this->db->where('domain', $domain)->from('domain');
  	$num_domain_listed = $this->db->count_all_results();
  	if($num_domain_listed == 0){
  		$insert_data = array(
  				'domain' => $domain,
  				'n_comments' => $num_new_comments,
  				'n_comments_all' => $num_new_comments,
  				'n_wordpress_comments' => $num_new_comments
  		);
  		$this->db->insert('domain', $insert_data);
  	}
  	else{
  		$this->db->where('domain', $domain);
  		$ret = $this->db->set('n_comments', 'n_comments+'.$num_new_comments, false)->set('n_comments_all', 'n_comments_all+'.$num_new_comments, false)->set('n_wordpress_comments', 'n_wordpress_comments+'.$num_new_comments, false)->update('domain');
  	}
  	
  	$nowpage = $_POST['nowpage'];
  	$key = 'import_wp_to_uyan_comments_' . $domain;
  	
  	$result = $this->mem->get($key);
  	if($result !== false) {
  		if($result < $nowpage) $this->mem->set($key, $nowpage);
  		echo $result;
  	} else {
  		$this->mem->set($key, $nowpage);
  	}
  	
  }


  function getSinaShortURL($longURL){
    $url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=507593302&url_long=' . $longURL;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $output_json = json_decode($output);
    $short_url =  $output_json[0]->url_short;
    return $short_url;
  }


  /**
   * 正确的计算字符数的方法（对应微博的字数上线）
   */
  function correctNumWords($str){
    return (mb_strlen($str, 'utf8') + strlen($str))/2;
  }


  function getCommentsCNT(){
    $page = $this->input->post('page');
    $delStyle = $this->input->post('delStyle');

    $key = 'CommentsCNT_' . $page;
    $result = $this->mem->get($key);
    if($result !== false) {
    	if($delStyle == 1)
			return $result['n_comments_all'];
		else
			return $result['n_comments'];
    } else {
    	$this->db->where('page', $page)->from('page');
		$query = $this->db->select('n_comments_all, n_comments')->get();
		if($query->num_rows() == 0)
			return 0;
		else{
			$query_results = $query->result();
			$query_result = $query_results[0];
			$data = array(
				'n_comments_all' => $query_result->n_comments_all,
				'n_comments' => $query_result->n_comments
			);
			$this->mem->set($key, $data, 3600);
			if($delStyle == 1)
				return $data['n_comments_all'];
			else
				return $data['n_comments'];
		}
  	}
  	
  	
  	
  	//OLD
    $page = $this->input->post('page');
    $delStyle = $this->input->post('delStyle');

    $this->db->where('page', $page)->from('page');

    if($delStyle == 1){
      $query = $this->db->select('n_comments_all')->get();
    }
    else
      $query = $this->db->select('n_comments')->get();

    if($query->num_rows() == 0)
      return 0;
    else{
      $query_results = $query->result();
      $query_result = $query_results[0];

      if($delStyle == '1')
        return $query_result->n_comments_all;
      else
        return $query_result->n_comments;
    }
  }


  /**
   * Get comments of current page
   * @Return: array of two elements consisting of:
   *       1. comments from current user
   *       2. comments from all users
   */
  function getComments($order_by){
    $page = $this->input->post('page');
    $delStyle = $this->input->post('delStyle');
    // $page = $this->input->post('page_url');
    $commentPageNum = $this->input->post('commentPageNum');
    $numCommentsPerPage = $this->input->post('numCommentsPerPage');

    $startPage = $commentPageNum * $numCommentsPerPage;

    $key = 'Comments_' . $page;
    $result = $this->mem->get($key);
    
    if($result !== false) {
    	$data = $result;
    } else {
    	$query_str = "select comment.*, user.* from comment 
        LEFT JOIN user ON user.user_id = comment.user_id
        where comment.page = '$page' and comment.reply_to_comment_id=0";

    	$query_all_comments = $this->db->query($query_str);
    	$data = $query_all_comments->result_array();
    	
    	$this->mem->set($key, $data, 3600);
    }
    $tmpArr = array();
    $tmpData = array();
    foreach($data as $val) {
    	unset($val['sina_access_token']);
    	unset($val['sina_access_secret']);
    	unset($val['renren_access_token']);
    	unset($val['renren_refresh_token']);
    	unset($val['tencent_access_token']);
    	unset($val['tencent_access_secret']);
    	unset($val['qq_access_token']);
    	unset($val['qq_access_secret']);
    	unset($val['kaixin_access_token']);
    	unset($val['kaixin_access_secret']);
    	unset($val['sohu_access_token']);
    	unset($val['sohu_access_secret']);
    	unset($val['neteasy_access_token']);
    	unset($val['neteasy_access_secret']);
    	unset($val['msn_access_token']);
    	unset($val['msn_authentication_token']);
    	unset($val['douban_access_token']);
    	unset($val['douban_access_secret']);
    	if($delStyle == 0) {
    		if($val['veryfy_status'] == 0) {
	    		$tmpData[] = $val;
	    		$tmpArr[] = $val[$order_by];
    		}
    	} else {
    		$tmpData[] = $val;
    		$tmpArr[] = $val[$order_by];
    	}
    }
    array_multisort($tmpArr, SORT_DESC, $tmpData);
    $tmpArr = array_values($tmpData);
    $tmpData = array_chunk($tmpArr, $numCommentsPerPage);
    return isset($tmpData[$commentPageNum]) ? $tmpData[$commentPageNum] : '';
    
    
    // OLD
    $page = $this->input->post('page');
    $delStyle = $this->input->post('delStyle');

    //$page = $this->input->post('page_url');
    $commentPageNum = $this->input->post('commentPageNum');
    $numCommentsPerPage = $this->input->post('numCommentsPerPage');

    $startPage = $commentPageNum * $numCommentsPerPage;

    if($delStyle == '0'){
      //update by vincent 2011/10/7
      //$query_str = "select comment.*, user.* from comment, user where comment.veryfy_status = 0 and comment.page = '$page' and comment.user_id=user.user_id and comment.reply_to_comment_id=0 order by comment.$order_by desc limit $startPage, $numCommentsPerPage";
      $query_str = "select comment.*, user.* from comment 
        LEFT JOIN user ON user.user_id = comment.user_id
        where comment.veryfy_status = 0 and comment.page = '$page' and comment.reply_to_comment_id=0 order by comment.$order_by desc limit $startPage, $numCommentsPerPage";
    }else{
      //update by vincent 2011/10/7
      //$query_str = "select comment.*, user.* from comment, user where comment.page = '$page' and comment.user_id=user.user_id and comment.reply_to_comment_id=0 order by comment.$order_by desc limit $startPage, $numCommentsPerPage";
      $query_str = "select comment.*, user.* from comment
        LEFT JOIN user ON user.user_id = comment.user_id
        where comment.page = '$page' and comment.reply_to_comment_id=0 order by comment.$order_by desc limit $startPage, $numCommentsPerPage";
    }
    $query_all_comments = $this->db->query($query_str);
    return $query_all_comments->result_array();
  }



  function getRepliesTogether($order_by){
    $ret_array = array();
    $page = $_POST['page'];
    $reply_page_nos = $this->input->post('reply_page_no');
    $comment_ids = $_POST['comment_ids'];

    foreach($comment_ids as $comment_id){
      $delStyle = $this->input->post('delStyle');
      $reply_page_no = $reply_page_nos[$comment_id]; //$this->input->post('reply_page_no');
      $session_name = $this->input->post('session_name');
      $num_replys_per_thread = $_SESSION[$session_name]['num_replys_per_thread'];

      $startPos = $reply_page_no * $num_replys_per_thread;

      $totalCount;

      if($delStyle == '0'){
        $query_str = "select user.*, comment.* from comment
          LEFT JOIN user ON user.user_id = comment.user_id
          where comment.del=0 and comment.reply_to_comment_id=$comment_id order by comment.$order_by desc limit $startPos, $num_replys_per_thread";
        $this->db->from('comment')->where('reply_to_comment_id', $comment_id)->where('del', 0);
        $totalCount = $this->db->count_all_results();
      }
      else{
        $query_str = "select user.*, comment.* from comment
          LEFT JOIN user ON user.user_id = comment.user_id
          where comment.reply_to_comment_id=$comment_id order by comment.$order_by desc limit $startPos, $num_replys_per_thread";
        $this->db->from('comment')->where('reply_to_comment_id', $comment_id);
        $totalCount = $this->db->count_all_results();
      }

      $query_replies = $this->db->query($query_str);
      if($startPos + $num_replys_per_thread >= $totalCount)
        $finished = 1;
      else
        $finished = 0;

      $one_result = array($comment_id, $finished, $query_replies->result_array());
      $ret_array[] = $one_result;
    }
    return $ret_array;
  }


  function getReplies($order_by){
    $comment_id = $this->input->post('comment_id');
    $delStyle = $this->input->post('delStyle');
    $reply_page_no = $this->input->post('reply_page_no');
    $session_name = $this->input->post('session_name');
    $num_replys_per_thread = $_SESSION[$session_name]['num_replys_per_thread'];

    $startPos = $reply_page_no * $num_replys_per_thread;

    $totalCount;

    if($delStyle == '0'){
      //update by vincent 2011/10/7
      //$query_str = "select user.*, comment.* from comment, user where comment.del=0 and comment.reply_to_comment_id=$comment_id and comment.user_id=user.user_id order by comment.$order_by desc limit $startPos, $num_replys_per_thread";
      $query_str = "select user.*, comment.* from comment
        LEFT JOIN user ON user.user_id = comment.user_id
        where comment.del=0 and comment.reply_to_comment_id=$comment_id order by comment.$order_by desc limit $startPos, $num_replys_per_thread";
      $this->db->from('comment')->where('reply_to_comment_id', $comment_id)->where('del', 0);
      $totalCount = $this->db->count_all_results();
    }
    else{
      //update by vincent 2011/10/7
      //$query_str = "select user.*, comment.* from comment, user where comment.reply_to_comment_id=$comment_id and comment.user_id=user.user_id order by comment.$order_by desc limit $startPos, $num_replys_per_thread";
      $query_str = "select user.*, comment.* from comment
        LEFT JOIN user ON user.user_id = comment.user_id
        where comment.reply_to_comment_id=$comment_id order by comment.$order_by desc limit $startPos, $num_replys_per_thread";
      $this->db->from('comment')->where('reply_to_comment_id', $comment_id);
      $totalCount = $this->db->count_all_results();
    }

    $query_replies = $this->db->query($query_str);
    if($startPos + $num_replys_per_thread >= $totalCount)
      $finished = 1;
    else
      $finished = 0;

    return array($finished, $query_replies->result_array());
  }

  function getCommentsByUser($user_id){
    //update by vincent 2011/10/7
    //$query_str = "select user.*, comment.* from comment, user where comment.user_id=$user_id order by comment.time desc";
    $query_str = "select user.*, comment.* from comment 
      LEFT JOIN user ON user.user_id = comment.user_id
      order by comment.time desc";
    $query_all_comments = $this->db->query($query_str); 
    return $query_all_comments->result_array();
  }

  function do_post_sina($content, $img, $page, $client, $query, $short_url, $comment_id){
    // To repost the page MB
    //$ret = null;
    $flag = 0;
    if($query->num_rows() != 0){
      $query_result = $query->row_array();
      $mid = $query_result['sina_mid'];
      if($mid != ''){
        $ret = $client->repost($mid, mb_substr($_POST['content'], 0, 140, 'utf8'));
        $flag = 1;
      }
    }

    if($flag == 0){
      if($img == 'none'){
        $ret = $client->update($content);
        var_dump($ret);
      }
      else{
        $ret = $client->upload($content, $img);
        var_dump($ret);
      }

      $page_sinaurl_time_data = array(
        'page' => $page,
        'sinaurl' => $short_url,
        'comment_id' => $comment_id
      );
      $this->db->insert('page_sinaurl_time', $page_sinaurl_time_data);
    }

    if($ret !=null and isset($ret['mid'])){
      $data = array(
        'feed_id' => $ret['mid']
      );
      $this->db->insert('incorporated_sina_feed', $data);
      //$this->db->set('sina_mid', $ret['mid'])->where('comment_id', $comment_id)->update('comment');
    }
    var_dump($ret);
  }

  function do_post_neteasy($content, $img, $tblog){
    if($img == 'none' || $img == null){
      $ret = $tblog->update($content);
    }
    else{
      $target_path = 'images/1.jpg';
      $file_data = file_get_contents($img);
      file_put_contents($target_path, $file_data);
      $ret = $tblog->upload($content, $target_path);
    }
  }

  function do_post_sohu($content, $img, $sohu_o){
    $param = array("status" => $content);

        /*if($img != null and $img != 'none'){
          $target_path = 'images/1.jpg';
          $file_data = file_get_contents($img);
          file_put_contents($target_path, $file_data);
          $param['pic'] = $target_path;
          $url = 'http://api.t.sohu.com/statuses/upload.json';
        }else{*/
    $url = 'http://api.t.sohu.com/statuses/update.json';
    //}
    $my_info = $sohu_o->post($url, $param);
  } 

  function do_post_tencent($content, $img_arr, $page, $tencent_c, $query, $comment_id){
    if($query->num_rows() != 0){
      $query_result = $query->row_array();
      $mid = $query_result['tencent_mid'];
      if($mid != ''){
echo 'mid is not empty';
        $p = array('c' => $_POST['content'], 'ip'=>'', 'j'=>'', 'w'=>'', 'type'=>4, 'p'=>$img_arr, 'r'=>$mid);
        $ret = $tencent_c->postOne($p);
        var_dump($ret);
        return;
      }
    }

    // either mid = 0 or num_rows = 0; 
    $p = array('c' => $content, 'ip'=>'', 'j'=>'', 'w'=>'', 'type'=>1, 'p'=>$img_arr);
    $ret = $tencent_c->postOne($p);

    if($ret['errcode'] == 0){
      $tencent_mid = $ret['data']['id'];
      $page_tencentmid_time_data = array(
      'page' => $page,
      'tencent_mid' => $tencent_mid,
      'comment_id' => $comment_id
	);
var_dump($page_tencentmid_time_data);
    $this->db->insert('page_tencentmid_time', $page_tencentmid_time_data);
    var_dump($ret);
    }
  }


  /**
   * True 则是有敏感过滤词
   * False 则是没有
   */
  function checkSpamWords($domain, $txt){
  	if(!function_exists('trie_filter_load') || !function_exists('trie_filter_search')) {
  		return false;
  	}
    $key = 'filter_' . $domain;
    $trie_filter = $this->mem->get($key);
    if($trie_filter == false) {
      $trie_filter = trie_filter_load('spam_dics/' . $domain);
      $this->mem->set($key, $trie_filter);
    }
    $ret = trie_filter_search($trie_filter, $txt);
    if(count($ret) == 0)
      return false;
    else
      return true;
  }


  function postCommentToSNS($from_type,$user_id,$comment_id){
    $img = trim($this->input->post('page_img'));
    $session_name = $this->input->post('session_name');

    if($_SESSION[$session_name]['image_style']==0){
      $img = 'none';
    }
    else if($img=='http://uyan.cc/images/loading.gif'){
      $img = 'none';
    }
    $page = $this->input->post('page');

//得到短连接
    $page_with_traceback = "http://uyan.cc/index.php/trace_back?url=" . urlencode($this->input->post('page_url'). "&page=" . $page ."&from_type=" . $from_type. "&comment_id=" . $comment_id . "&user_id=" . $user_id  );

    $short_url = $this->getSinaShortURL($page_with_traceback);
    $title = $this->input->post('title');

    $domain_part = '';
    if($_SESSION[$session_name]['domain_name'] !=''){
      $domain_part = $_SESSION[$session_name]['domain_name'] ;
    }
    else
      $domain_part = '（'.$_SESSION[$session_name]['domain'].'）';

    $content_template = $_SESSION[$session_name]['message_sns'];		
    $content_template=str_ireplace('{user_comment}',$_POST['content'],$content_template);
    $content_template=str_ireplace('{page_title}',$title,$content_template);
    $content_template=str_ireplace('{website_info}',$domain_part,$content_template);
    $content_template=str_ireplace('{short_link}',$short_url,$content_template);
    $content = &$content_template;

    switch($from_type){
    case 'SINA':
      /* Get the short url and build the sina_content first */
      $c = new WeiboClient( SINA_AKEY , SINA_SKEY , $_SESSION['login']['sina']['access_token'], $_SESSION['login']['sina']['access_secret']);
      $query = $this->db->select('sina_mid')->from('page_mid')->where('page', $page)->get();

      if($this->correctNumWords($content) > 280){
        $content_template_length = $this->correctNumWords($content_template) - $this->correctNumWords('{user_comment}') - $this->correctNumWords('{page_title}') - $this->correctNumWords('{website_info}') - $this->correctNumWords('{short_link}');
        $content_part = mb_substr($_POST['content'], 0, 125 - $this->correctNumWords($domain_part) - $this->correctNumWords($title), 'utf8') . '...';
        $content_template = $_SESSION[$session_name]['message_sns'];		
        $content_template=str_ireplace('{user_comment}',$content_part,$content_template);
        $content_template=str_ireplace('{page_title}',$title,$content_template);
        $content_template=str_ireplace('{website_info}',$domain_part,$content_template);
        $content_template=str_ireplace('{short_link}',$short_url,$content_template);
        $content = $content_template;
        //echo $this->correctNumWords($content);
      }

      if(isset($_POST['in_reply_to']))
        $this->do_post_sina($content, $img, $page, $c, $query, $short_url, $_POST['in_reply_to']);
      else
        $this->do_post_sina($content, $img, $page, $c, $query, $short_url, $comment_id);

      break;

    case 'RENREN':
      $client = new RenRenClient();
      $client->setSessionKey($_SESSION['login']['renren']['session_key']);
      $description = '我才在“' . $domain_part . '”的页面《' . $title . '》发表此评论';

      $orig_content = $_POST['content'];
      if($this->correctNumWords($orig_content) > 200)
        $orig_content = mb_substr($orig_content, 0, 200, 'utf8');

      if($this->correctNumWords($title) > 30)
        $title = mb_substr($title, 0, 30, 'utf8');

      if($img == 'none'){
        $info = $client->POST('feed.publishFeed', array($orig_content, $title, $description, $short_url, 'http://uyan.cc/images/YYL.png'));
      }
      else{
        $info = $client->POST('feed.publishFeed', array($orig_content, $title, $description, $short_url, $img));
      }
      var_dump($info);
      break;

    case 'KAIXIN':
      echo $img;
      $connection = new KXClient(KAIXIN_CONSUMER_KEY, KAIXIN_CONSUMER_SECRET, $_SESSION['login']['kaixin']['access_token'], $_SESSION['login']['kaixin']['access_secret']);

      if($img == 'none'){
        $ret = $connection->records_add($content);
      }
      else{
        $ret = $connection->records_add($content, '', $img);
      }
      var_dump($ret);
      break;

    case 'NETEASY':
      $tblog = new TBlog(NETEASY_WB_AKEY, NETEASY_WB_SKEY, $_SESSION['login']['neteasy']['access_token'], $_SESSION['login']['neteasy']['access_secret']);

      if($this->correctNumWords($content) > 326){
        $content_part = mb_substr($_POST['content'], 0, 152 - $this->correctNumWords($domain_part) - $this->correctNumWords($title), 'utf8') . '...';
        $content_template=str_ireplace('{user_comment}',$content_part,$content_template);
        $content_template=str_ireplace('{page_title}',$title,$content_template);
        $content_template=str_ireplace('{website_info}',$domain_part,$content_template);
        $content_template=str_ireplace('{short_link}',$short_url,$content_template);
        $content = $content_template;
      }
      $this->do_post_neteasy($content, $img, $tblog);
      break;

    case 'SOHU':
      $sohu_o = new SohuOAuth(SOHU_CONSUMER_KEY, SOHU_CONSUMER_SECRET, $_SESSION['login']['sohu']['access_token'], $_SESSION['login']['sohu']['access_secret']);

      if($this->correctNumWords($content) > 4000){
        $content_part = mb_substr($_POST['content'], 0, 1980 - $this->correctNumWords($domain_part) - $this->correctNumWords($title), 'utf8') . '...';
        $content_template=str_ireplace('{user_comment}',$content_part,$content_template);
        $content_template=str_ireplace('{page_title}',$title,$content_template);
        $content_template=str_ireplace('{website_info}',$domain_part,$content_template);
        $content_template=str_ireplace('{short_link}',$short_url,$content_template);
        $content = $content_template;
      }
      $this->do_post_sohu($content, $img, $sohu_o);
      break;


    case 'TENCENT':
      $tencent_c = new MBApiClient( TENCENT_AKEY , TENCENT_SKEY , $_SESSION['login']['tencent']['access_token'], $_SESSION['login']['tencent']['access_secret']);

      if($img != null and $img != 'none'){
        $img_arr = array("image/gif",$img,file_get_contents($img));
      }else{
        $img_arr = null;
      }

      $query = $this->db->select('tencent_mid')->from('page_mid')->where('page', $page)->get();

      if($this->correctNumWords($content) > 280){
        $content_part = mb_substr($_POST['content'], 0, 129 - $this->correctNumWords($domain_part) - $this->correctNumWords($title), 'utf8') . '...';
        $content_template=str_ireplace('{user_comment}',$content_part,$content_template);
        $content_template=str_ireplace('{page_title}',$title,$content_template);
        $content_template=str_ireplace('{website_info}',$domain_part,$content_template);
        $content_template=str_ireplace('{short_link}',$short_url,$content_template);
        $content = $content_template;
      }
      $this->do_post_tencent($content, $img_arr, $page, $tencent_c, $query, $comment_id);
      break;

    case 'QQ':
      $_POST['url'] = $short_url;
      $_POST['comment'] = $content;
      $_POST['images'] = $_POST['page_img'];
      add_share(QQ_APPID, QQ_APPKEY, $_SESSION['login']['qq']["access_token"], $_SESSION['login']['qq']["access_secret"], $_SESSION["login"]['qq']['id']);
      break;

    case 'MSN':
      $method_data = array(
        'message' => $content,
        'link' => $short_url,
        'description' => '我才通过\'友言\'社交评论系统发表此评论'
      );
      if($_POST['page_img'] != 'none')
        $method_data['picture'] = $_POST['page_img'];
      //'name' 
      $header_array = array('Content-Type: application/json');
      $results_share = callRestApi($_SESSION['login']['msn']['access_token'],
        REST_PATH_SHARE, 
        REST_API_POST,
        $header_array, json_encode($method_data));
      var_dump($results_share);
      break;
    }
  }


  function postComment(){
    $user_id = $this->input->post('user_id');
    $page = $this->input->post('page');
    $page_url = $this->input->post('page_url');
    $page_title = $this->input->post('title');
    $vote_score = $this->input->post('vote_score');
    $domain = $this->input->post('domain');
    $content = htmlspecialchars($this->input->post('content'));

    $key = 'Comments_' . $page;	// 临时处理方案
    $this->mem->delete($key);
    $key = 'CommentsCNT_' . $page;	// 临时处理方案
    $this->mem->delete($key);
    
    if(isset($_POST['time']))
      $date = $_POST['time'];
    else
      $date = date('Y-m-d H:i:s');
    $from_type = $this->input->post('from_type');
    $comment_author= $this->input->post('comment_author');
    $comment_author_email= $this->input->post('comment_author_email');
    $comment_author_url= $this->input->post('comment_author_url');
    $session_name = 'uyan_'.$domain;
    //prepare $veryfy_status
    $veryfyCheck = $this->input->post('veryfyCheck');
    if($veryfyCheck==1){
      $veryfy_status = 1;
    }else{
      $veryfy_status = 0;
    }

    $current_ip = $this->getIP();

    //check spam from black list.		
    $totalBlack = mysql_query("SELECT * FROM spam WHERE level = 1");
    $totalBlack = mysql_fetch_array($totalBlack);
    $getBlack = mysql_query("SELECT * FROM domain_spam WHERE domain = '$domain'");
    $getBlack = mysql_fetch_array($getBlack);



    if($this->checkSpamWords($domain, $content) == true)
      $veryfy_status = 2;

    //check email	
    $emailStr = $totalBlack['email'].$getBlack['email'];
    if(!is_bool(stripos($emailStr,$comment_author_email)) && mb_strlen($comment_author_email)>1){
      $veryfy_status = 2;
    }

    //check user_name
    $nameStr = $totalBlack['user_name'].$getBlack['user_name'];		
    if(!is_bool(stripos($nameStr,$comment_author)) && $comment_author!=NULL&&mb_strlen($comment_author)>1){
      $veryfy_status = 2;
    }
    //check ip
    $ipStr = $totalBlack['ip'].$getBlack['ip'];
    if(!is_bool(stripos($ipStr,$current_ip))&&mb_strlen($current_ip)>1){
      $veryfy_status = 2;
    }
    //check user_id
    $idStr = $totalBlack['user_id'].$getBlack['user_id'];		
    if(!is_bool(stripos($idStr,$user_id)) && $user_id!=NULL&&mb_strlen($user_id)>1&& $user_id!=100){
      $veryfy_status = 2;
    }

    //check words
    $wordStr = $totalBlack['word'].$getBlack['word'];
    
    //check spam cookie
    if(isset($_COOKIE['UYComment'])&&$_COOKIE['UYComment']==$content){
      if(isset($_COOKIE['UYCommentSpamNum'])){
        setcookie('UYCommentSpamNum',(int)$_COOKIE['UYCommentSpamNum']+1,time()+3600*5);
        if($_COOKIE['UYCommentSpamNum']>=5){
          exit(json_encode('spam'));
        }
      }else{
        setcookie('UYCommentSpamNum',1,time()+3600*5);
      }
      exit(json_encode('again'));
    }else{
      setcookie('UYCommentSpamNum',0,time()+3600*5);
    }
    //check spam session
    if(isset($_SESSION['UYSpamTime'])&&(time()-$_SESSION['UYSpamTime'])<=5){
      exit(json_encode('short'));
    }


    $insert_data = array(
      'page' => $page,
      'page_url' => $page_url,
      'user_id' => $user_id,
      'content' => $content,
      'time' => $date,
      'domain' => $domain,
      'page_title' => $page_title,
      'n_up' => 0,
      'n_down' => 0,
      'from_type' => $from_type,
      'hotness' => 1,
      'comment_author' =>$comment_author,
      'comment_author_email' =>$comment_author_email,
      'comment_author_url' =>$comment_author_url,
      'ip' => $current_ip,
      'vote_star' => $vote_score,
      'veryfy_status'=>$veryfy_status
    );
    $args = func_get_args();
    if(isset($_POST['in_reply_to'])){
      $insert_data['reply_to_comment_id'] = $_POST['in_reply_to'];
      $this->db->set('hotness', 'hotness + 1', false);
      $this->db->where('comment_id', $_POST['in_reply_to'])->update('comment');
    }

    $insert_query = $this->db->insert('comment', $insert_data);
    if($insert_query == 1){
      $comment_id = $this->db->insert_id();
    }
    $query_str = "select user.*, comment.* from comment, user where comment.user_id=user.user_id and comment_id=$comment_id order by comment.time desc";
    $new_inserted_row_query = $this->db->query($query_str); 
    $new_inserted_row = $new_inserted_row_query->row_array();
    //setcookie for spam
    setcookie('UYComment',$content,time()+3600*2);
    //setsession for spam
    $_SESSION['UYSpamTime'] = time();

    echo json_encode($new_inserted_row);

    if(isset($_POST['in_reply_to'])&&$_POST['in_reply_to']!=NULL&&$_POST['in_reply_to']!=''){
      $last_id = $_POST['in_reply_to'];
      $user_arr = mysql_query("SELECT * FROM comment WHERE comment_id = '$last_id'");
      $user_arr = mysql_fetch_array($user_arr);
      //update notification

      $noti_id_user = $user_arr['user_id'];
      if($noti_id_user!=100){
        $noti_user_name = $new_inserted_row['show_name'];
        $noti_profile_img = $new_inserted_row['profile_img'];
        mysql_query("INSERT INTO notification (type,user_id,show_name,profile_img,c_time,replyContent,send_id,link)VALUES('reply','$noti_id_user','$noti_user_name','$noti_profile_img','$date','$content','$user_id','$page_url')");
        mysql_query("UPDATE user SET noti= noti+1 WHERE user_id ='$noti_id_user'");
      }

      if($user_arr['comment_author_email']!=''&&$user_arr['comment_author_email']!=NULL){
        $targetEmail = 	$user_arr['comment_author_email'];
        $targetShowName = $user_arr['comment_author'];
      }else{
        $user_id_new = $user_arr['user_id'];
        if($user_id_new!=''){
          $target_user_arr = mysql_query("SELECT * FROM user WHERE user_id = '$user_id_new'");
          $target_user_arr = mysql_fetch_array($target_user_arr);
          $targetEmail = $target_user_arr['email'];

        }
      }
      if($targetEmail!=NULL&&$targetEmail!=''){
        if(isset($target_user_arr['show_name'])&&$target_user_arr['show_name']!=''){
          $user_name = $target_user_arr['show_name'];
        }else if(isset($targetShowName)&&$targetShowName!=''){
          $user_name = $targetShowName;
        }else{
          $user_name = '先生/女士 ';
        }

        $subject = $new_inserted_row['show_name'].'回复了您的评论';
        $content_email = $user_name."你好：<br/><br/>".$new_inserted_row['show_name']."在<a href='".$new_inserted_row['page_url']."' target='_blank'>".$new_inserted_row['page_title']."</a>回复了您:".$content."<br/><br/><br/>评论服务由友言提供 http://www.uyan.cc<br/>
          ________<br/>
          此邮件为系统自动生成邮件，请勿回复";
        $this->smtp_mail($targetEmail, $user_name,$content_email,$subject);
      }
    }
  }


  function postCommentPostWork(){
    $comment_id = $_POST['comment_id'];
    $user_id = $this->input->post('user_id');
    $page = $this->input->post('page');
    $page_url = $this->input->post('page_url');
    $page_title = $this->input->post('title');

    $domain = $this->input->post('domain');
    $content = $this->input->post('content');
    $date = date('Y-m-d H:i:s');
    $from_type = $this->input->post('from_type');
    $comment_author= $this->input->post('comment_author');
    $comment_author_email= $this->input->post('comment_author_email');
    $comment_author_url= $this->input->post('comment_author_url');

    // Check if it's new user commenting in this domain
    $is_new_domain_user = 0;
    if($user_id != 100){
      $this->db->where('domain', $domain)->where('user_id', $user_id);
      $this->db->from('comment');
      $query_result = $this->db->count_all_results();
      if($query_result == 1){
        $is_new_domain_user = 1;
      }
    }

    // Check if it's new user commenting in this page
    $is_new_page_user = 0;
    if($user_id != 100){
      $this->db->where('page', $page)->where('user_id', $user_id);
      $this->db->from('comment');
      $query_result = $this->db->count_all_results();
      if($query_result == 1){
        $is_new_page_user = 1;
      }
    }

    $n_type_comments = 'n_' . strtolower($from_type) . '_comments';
    $n_type_comments_1 = $n_type_comments . '+1';
    $n_type_users = 'n_' . strtolower($from_type) . '_users';
    $n_type_users_1 = $n_type_users . '+1';

    $this->db->set('n_comments', 'n_comments+1', false)->set('n_comments_all', 'n_comments_all+1', false)->set($n_type_comments, $n_type_comments_1, false);
    if($is_new_domain_user){
      $this->db->set('n_users', 'n_users+1', false);
      $this->db->set($n_type_users, $n_type_users_1, false);
    }
    $this->db->where('domain', $domain)->update('domain');


    /**
     * Update the 'page' tabel
     */
    $this->db->set('n_comments', 'n_comments+1', false)->set('n_comments_all', 'n_comments_all+1', false);
    $this->db->set($n_type_comments, $n_type_comments_1, false);
    if($is_new_page_user){
      $this->db->set('n_users', 'n_users+1', false);
      $this->db->set($n_type_users, $n_type_users_1, false);
    }
    $this->db->where('page', $page)->update('page');


    /**
     * Update the n_page field of domain
     */
    $this->db->where('domain', $domain)->where('page', $page);
    $this->db->from('comment');
    $query_result = $this->db->count_all_results();
    if($query_result == 1){
      // If this is a new page for current domain, also update the 'n_pages' in the domain table
      $this->db->set('n_pages', 'n_pages+1', false);
      $this->db->where('domain', $domain)->update('domain');
    }

    /**
     * Update the user table
     */
    $this->db->where('user_id', $user_id)->set('n_comments', 'n_comments+1', false)->set('n_comments_all', 'n_comments_all+1', false)->set($n_type_comments, $n_type_comments_1, false)->update('user');

    /**
     * Update the domain_user table
     */
    $count_domain_user = $this->db->where('domain', $domain)->where('user_id', $user_id)->from('domain_user')->count_all_results();
    if($count_domain_user == 0){
      $data = array(
        'domain' => $domain,
        'user_id' => $user_id,
        'n_comments' => 1,
        'n_comments_all' => 1,
        $n_type_comments => 1
      );
      $this->db->insert('domain_user', $data);
    }
    else
      $this->db->where('domain', $domain)->where('user_id', $user_id)->set('n_comments', 'n_comments+1', false)->set('n_comments_all', 'n_comments_all+1', false)->set($n_type_comments, $n_type_comments_1, false)->update('domain_user');

    $postToSNS = $this->input->post('postToSNS');

    if(isset($_POST['uyan_init_post'])){
      $this->doInitPost();
      return;
    }

    if($postToSNS == 'true'){
      $this->postCommentToSNS($from_type,$user_id,$comment_id);
    }
    //update commentAmount notification
    //

    $this->commentEmail($domain);
  }

  function doInitPost(){
    $from_type = $_POST['from_type'];
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $page = $_POST['page'];
    $page_url = $_POST['page_url'];

    $page_with_traceback = "http://uyan.cc/index.php/trace_back?url=" . urlencode($page_url . "&page=" . $page ."&from_type=" . $from_type. "&comment_id=" . $comment_id . "&user_id=" . $user_id  );

    $short_url = $this->getSinaShortURL($page_with_traceback);
    $title = $_POST['title'];

    $content_template = $_SESSION[$session_name]['message_sns'];		
    $content_template=str_ireplace('{user_comment}',$_POST['content'],$content_template);
    $content_template=str_ireplace('{page_title}',$title,$content_template);
    $content_template=str_ireplace('{website_info}',$domain_part,$content_template);
    $content_template=str_ireplace('{short_link}',$short_url,$content_template);

    $content =  $content_template;

    /* Get the short url and build the sina_content first */
    $c = new WeiboClient( SINA_AKEY , SINA_SKEY , '25bf5cd48b917ed229d2283c507c5d95', '91d47f2a3c14a19269f4fde46fa5c69d');

    if($this->correctNumWords($content) > 280){
      $content_part = mb_substr($_POST['content'], 0, 129 - mb_strlen($content_prefix, 'utf8'), 'utf8');
      $content = $content_prefix . $content_part . '...' . $short_url;
    }
    $c->update($content);
  }


  function increaseCnt($up_or_down){
    $comment_id = $this->input->post('comment_id');
    $user_id = $this->input->post('user_id');
    $current_domain = $this->input->post('domain');
    $insert_data = array(
      'user_id' => $user_id,
      'comment_id' => $comment_id
    );
    $this->db->insert('comment_user_'.$up_or_down, $insert_data);


    $this->db->set('hotness', 'hotness+1', false)->where('comment_id', $comment_id)->update('comment');

    $this->db->set('n_'. $up_or_down .'_give', 'n_' .$up_or_down . '_give+1', false)->where('user_id', $user_id)->update('user');

    $field_name = 'n_'.$up_or_down;
    $this->db->set($field_name, $field_name.'+1', false);
    $this->db->where('comment_id', $comment_id)->update('comment');

    //update the target user's n_up_received and n_down_received
    $target_user = mysql_query("SELECT user_id,page_url FROM comment WHERE comment_id='$comment_id'");
    $target_user = mysql_fetch_array($target_user);
    $target_user_id = $target_user['user_id'];
    mysql_query("UPDATE user SET n_".$up_or_down."_received = n_".$up_or_down."_received+1 WHERE user_id='$target_user_id'");
    if($up_or_down=='up'){
      $noti_id_user = $target_user_id;
      if($noti_id_user!=100){
        $send_user = mysql_query("SELECT * FROM user WHERE user_id = '$user_id'");
        $send_user = mysql_fetch_array($send_user);
        $page_url = $target_user['page_url'];
        $noti_user_name = $send_user['show_name'];
        $noti_profile_img = $send_user['profile_img'];
        $date = date('Y-m-d H:i:s');
        mysql_query("INSERT INTO notification (type,user_id,show_name,profile_img,c_time,send_id,link)VALUES('voteUp','$noti_id_user','$noti_user_name','$noti_profile_img','$date','$user_id','$page_url')");
        mysql_query("UPDATE user SET noti= noti+1 WHERE user_id ='$noti_id_user'");
      }
    }
    /* dealing with the domain_user table*/
    mysql_query("UPDATE domain_user SET n_".$up_or_down."_received = n_".$up_or_down."_received+1 WHERE user_id ='$target_user_id' AND domain = '$current_domain'");

    /* dealing with hotness of parent comment */
    $query = $this->db->where('comment_id', $comment_id)->select('reply_to_comment_id')->get('comment');
    $query_results = $query->result();
    $query_result = $query_results[0];
    if($query_result->reply_to_comment_id != 0){
      $this->db->set('hotness', 'hotness+1', false)->where('comment_id', $query_result->reply_to_comment_id)->update('comment');
    }

  }


  function decreaseCnt($up_or_down){
    $comment_id = $this->input->post('comment_id');
    $user_id = $this->input->post('user_id');
    $current_domain = $this->input->post('domain');
    $this->db->set('hotness', 'hotness-1', false)->where('comment_id', $comment_id)->update('comment');
    $this->db->where('comment_id', $comment_id)->where('user_id', $user_id)->delete('comment_user_'.$up_or_down);

    $field_name = 'n_'.$up_or_down;
    $this->db->set($field_name, $field_name.'-1', false);
    $this->db->where('comment_id', $comment_id)->update('comment');

    //update the target user's n_up_received and n_down_received
    $target_user = mysql_query("SELECT user_id FROM comment WHERE comment_id='$comment_id'");
    $target_user = mysql_fetch_array($target_user);
    $target_user_id = $target_user['user_id'];
    mysql_query("UPDATE user SET n_".$up_or_down."_received = n_".$up_or_down."_received-1 WHERE user_id='$target_user_id'");
    /* dealing with the domain_user table*/
    mysql_query("UPDATE domain_user SET n_".$up_or_down."_received = n_".$up_or_down."_received-1 WHERE user_id ='$target_user_id' AND domain = '$current_domain'");

    /* dealing with hotness of parent comment */
    $query = $this->db->where('comment_id', $comment_id)->select('reply_to_comment_id')->get('comment');
    $query_results = $query->result();
    $query_result = $query_results[0];
    if($query_result->reply_to_comment_id != 0){
      $this->db->set('hotness', 'hotness-1', false)->where('comment_id', $query_result->reply_to_comment_id)->update('comment');
    }
  }


  function checkUp(){
    $comment_id = $this->input->post('comment_id');
    $user_id = $this->input->post('user_id');
    $query = $this->db->where('comment_id', $comment_id)->where('user_id', $user_id)->from('comment_user_up');
    return $this->db->count_all_results();
  }

  function checkDown(){
    $comment_id = $this->input->post('comment_id');
    $user_id = $this->input->post('user_id');
    $query = $this->db->where('comment_id', $comment_id)->where('user_id', $user_id)->from('comment_user_down');
    return $this->db->count_all_results();
  }



  //for admin page
  function getCommentsByDomain($domainURL,$from_item){
    $start_item = 20*$from_item;
    $normalCommentToogle = $this->input->post('normalCommentToogle');
    $readyCommentToogle = $this->input->post('readyCommentToogle');
    $trashCommentToogle = $this->input->post('trashCommentToogle');
    $delCommentToogle = $this->input->post('delCommentToogle');
    $selectStr = ',';
    if($normalCommentToogle=='1')$selectStr = $selectStr.'0,';
    if($readyCommentToogle=='1')$selectStr = $selectStr.'1,';
    if($trashCommentToogle=='1')$selectStr = $selectStr.'2,';
    if($delCommentToogle=='1')$selectStr = $selectStr.'3,';
    //update by vincent 2011/10/7
        /*$query_str = "select comment.*, user.* from comment, user 
        where comment.user_id=user.user_id AND FIND_IN_SET(veryfy_status,'$selectStr')>=1 AND comment.domain='$domainURL' order by comment.time desc LIMIT $start_item, 20";*/
    $query_str = "select comment.*, user.* from comment 
      LEFT JOIN user ON user.user_id = comment.user_id 
      where FIND_IN_SET(veryfy_status,'$selectStr')>=1 AND comment.domain='$domainURL' order by comment.time desc LIMIT $start_item, 20";
    $query_all_comments = $this->db->query($query_str);
    return $query_all_comments->result();
  }
  //for admin page
  function getCommentsByPage($domainURL,$from_item){
    $start_item = 20*$from_item;
    $page = $this->input->post('page');
    //update by vincent 2011/10/7
        /*$query_str = "select comment.n_up as n_up, comment.time as time, comment.*, user.* from comment, user 
        where comment.user_id=user.user_id and comment.page='$page' AND comment.del=0 order by comment.time desc LIMIT $start_item, 20";*/
    $query_str = "select comment.n_up as n_up, comment.time as time, comment.*, user.* from comment 
      LEFT JOIN user ON user.user_id = comment.user_id
      where comment.page='$page' AND comment.del=0 order by comment.time desc LIMIT $start_item, 20";
    $query_all_comments = $this->db->query($query_str);
    return $query_all_comments->result();
  }
  
  function accessComment($commentId){
    if($commentId!=''){
      mysql_query("UPDATE comment SET veryfy_status = 0 WHERE comment_id = '$commentId'");		
    }
  }

  function delComment($commentId){
    //$del_style = $this->input->post('del_style');
    $count = $this->input->post('count');

    if($count == ''){  // && isset($_SESSION['domain']['delStyle']))
      $query = $this->db->where('del', 0)->where('reply_to_comment_id', $commentId)->from('comment');
      $count_child = $this->db->count_all_results();  
      $count = $count_child + 1;
    }

    $query_str = "UPDATE comment SET del = '1', veryfy_status='3' WHERE comment_id =$commentId";
    $query_all_comments = $this->db->query($query_str);

    $query_info = "select hotness, from_type, page, domain from comment where comment_id = $commentId";
    $query = $this->db->query($query_info);
    $query_results = $query->result();

    $query_result = $query_results[0];
    $domain = $query_result->domain;
    $page = $query_result->page;
    $from_type = $query_result->from_type;

    $hotness = $query_result->hotness;

    $n_type_comments = 'n_' . strtolower($from_type) . '_comments';
    $n_type_comments_1 = $n_type_comments . '-1';

    $this->db->set('n_comments', 'n_comments-'. $count, false)->set($n_type_comments, $n_type_comments_1, false);
    $this->db->where('domain', $domain)->update('domain');

    $this->db->set('n_comments', 'n_comments-'. $count, false)->set($n_type_comments, $n_type_comments_1, false);
    $this->db->where('page', $page)->update('page');

    /* dealing with hotness of parent comment */
    $query = $this->db->where('comment_id', $commentId)->select('reply_to_comment_id')->get('comment');
    $query_results = $query->result();
    $query_result = $query_results[0];
    if($query_result->reply_to_comment_id != 0){
      $this->db->set('hotness', 'hotness-' . $hotness, false)->where('comment_id', $query_result->reply_to_comment_id)->update('comment');
    }
    return true;	  
  }


  function getReplyComment($ruid){
    $query_str = "select user.* from user					
      where user.user_id='$ruid' ";
    $query_user = $this->db->query($query_str);
    return $query_user->result();
  }

  function checkCSSFile($url){
    if(file_exists($url)){ 
      return 1;
    }else{
      return 0; 
    }
  }

  function smtp_mail($sendto_email, $user_name,$content,$subject){
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

  function commentEmail($domainPre){
    $domain_info = mysql_query("SELECT * FROM domain where domain = '$domainPre'");
    $domain_row = mysql_fetch_array($domain_info);
    if($domain_row['mailNotify'] < 0)
      return;
    else if ($domain_row['mailNotify'] - $domain_row['curMail'] <= 1){
      $checkComment = mysql_query("SELECT DISTINCT show_name  FROM comment 
        JOIN user ON user.user_id = comment.user_id 
        WHERE domain = '$domainPre' AND notified = 1 LIMIT 0,10" );
      $namelist= '';

      while($row = mysql_fetch_array($checkComment)){
        $namelist = $namelist.$row['show_name'].', ';
      }
      $time = date("n月j日");
      $subject = '网站新评论通知['.$time.']';

      $master_info = mysql_query("SELECT * FROM master_domain WHERE domain = '$domainPre' AND	verified= 1");

      while($master_row = mysql_fetch_array($master_info)){
        $master_id = $master_row['master_id'];
        $master_str = mysql_query("SELECT * FROM master WHERE master_id = '$master_id'");
        $master_exist = mysql_num_rows($master_str);

        if($master_exist>0&&$master_id!=0){
          $master_arr = mysql_fetch_array($master_str);
          if($domain_row['mailNotify']==1){
            $content = '<div style="background-color:#3B5998;color:#fff;font-size:12px;padding:5px 0 5px 0; text-align:center;">请将help@uyan.cc添加至联系人，以保证邮件能够正常接收。</div><br/>'.$master_arr['nick'].'您好:<br/><br/><span style="font-weight:bold">'.$namelist.'</span>在您的网站上评论了。<br/>请登录您的网站，或在<a href="http://www.uyan.cc/" target="_blank">友言管理页面</a>中查看。<br/><br/>祝您使用愉快！<br/>友言客服<br/>www.uyan.cc<br/><span style="font-size:12px;color:#aaa;">如不再需要定期报告，请在友言管理页面中设置。</span>';	
          }else{
            $content = '<div style="background-color:#3B5998;color:#fff;font-size:12px;padding:5px 0 5px 0; text-align:center;">请将help@uyan.cc添加至联系人，以保证邮件能够正常接收。</div><br/>'.$master_arr['nick'].'您好:<br/><br/><span style="font-weight:bold">'.$namelist.'</span>等人在您的网站上评论了。<br/>共有'.($domain_row['mailNotify']).'条新评论，请登录您的网站，或在<a href="http://www.uyan.cc/" target="_blank">友言管理页面</a>中查看。<br/><br/>祝您使用愉快！<br/>友言客服<br/><span style="color:#666;font-size:14px;">www.uyan.cc</span><br/><span style="font-size:12px;color:#aaa;">如不再需要定期报告，请在友言管理页面中设置。</span>';
          }
          $this->smtp_mail($master_arr['email'], $master_arr['nick'],$content,$subject);
        }
      }
      //clear amount;
      mysql_query("UPDATE domain SET curMail = 0 WHERE domain = '$domainPre'");
      mysql_query("UPDATE comment SET notified = 0 WHERE domain = '$domainPre'");
      return 'send';
    }else{
      $this->db->where('domain', $domainPre);
      $this->db->set('curMail', 'curMail+1', false)->update('domain');
      return 'not enough';
    }
  }

  function getHotComments(){
    $domain = $this->input->post('domain');
    $rankType = $this->input->post('rankType');
    $rank_item_amount_hot = $this->input->post('commentHotAmount');
    $rank_item_amount_time = $this->input->post('commentTimeAmount');
    $period = $this->input->post('periodExist');
    if($rankType=='hotness'){
      $rank_item_amount = $rank_item_amount_hot;

      //check date
      if($period==-1){
        $limiStr = '';
      }else{
        $currentDate = time()-60*60*24*$period;
        $currentTime = date("Y-m-d",$currentDate);			
        $limiStr = "AND to_days(time) >= to_days('".$currentTime."')";
      }
    }else{
      $rank_item_amount = $rank_item_amount_time;
      $limiStr = '';
    }
    $query_str = "SELECT * FROM comment 
      LEFT JOIN user ON user.user_id = comment.user_id
      WHERE comment.domain = '$domain' AND comment.veryfy_status=0 AND comment.veryfy_status=0 AND comment.reply_to_comment_id=0 ".$limiStr." ORDER BY ".$rankType." DESC LIMIT 0,".$rank_item_amount."";

    $query_user = $this->db->query($query_str);
    return $query_user->result();
  }
  function getListArticle(){
    $domain = $this->input->post('domain');
    $rankType = $this->input->post('rankType');
    $articleTimeAmount = $this->input->post('articleTimeAmount');
    $articleHotAmount = $this->input->post('articleHotAmount');
    $period = $this->input->post('periodExist');
    if($rankType=='hotness'){
      $articleAmount = $articleHotAmount;
      $rankPro = 'n_comments';
      //check date
      if($period==-1){
        $limiStr = '';
      }else{
        $currentDate = time()-60*60*24*$period;
        $currentTime = date("Y-m-d",$currentDate);			
        $limiStr = "AND to_days(time) >= to_days('".$currentTime."')";
      }
    }else{
      $articleAmount = $articleTimeAmount;
      $rankPro = 'time';
      $limiStr = '';
    }
    $query_str = "SELECT * FROM page WHERE domain ='$domain' AND page.page_title!='' ".$limiStr." ORDER BY ".$rankPro." DESC LIMIT 0,".$articleAmount."";
    $query_article = $this->db->query($query_str);
    return $query_article->result();

  }
}
