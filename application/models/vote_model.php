<?php
require_once(APPPATH."inc/config.php");
require_once(APPPATH.'/inc/renren_config.php');

class vote_Model extends CI_Model {
  function increasePageCnt($up_or_down){
    $user_id = $this->input->post('user_id');
    $page = $this->input->post('page');
    $voterState = 0;
    //get Domain
    $domainArr = mysql_query("SELECT domain FROM page WHERE page.page ='$page'");
    $domainArr = mysql_fetch_array($domainArr);
    $domain = $domainArr[0];
    //prepare domain_user table
    $domain_user = mysql_query("SELECT * FROM domain_user WHERE user_id='$user_id' AND domain='$domain' ");
    if(mysql_num_rows($domain_user)==0){
      mysql_query("INSERT INTO domain_user (domain,user_id)VALUES('$domain','$user_id')");
    }
    if($up_or_down=='up'){
      //vote state
      //update page to get higher vote
      mysql_query("UPDATE page SET n_up = n_up+1 WHERE page = '$page'");

	  mysql_query("UPDATE domain SET n_up = n_up+1 WHERE domain = '$domain'");
      //update user_domain 
      mysql_query("UPDATE domain_user SET n_up = n_up+1 WHERE domain = '$domain' AND user_id = '$user_id' ");
      //update page_user_up
      mysql_query("INSERT INTO page_user_up (page,domain,user_id)VALUE('$page','$domain','$user_id')");
      //update user to know his vote selection
      mysql_query("UPDATE user SET n_up = n_up+1 WHERE user_id = '$user_id'");
      //check page_user_down and del it.
      $page_user_down_state = mysql_query("SELECT page FROM page_user_down WHERE page='$page' AND user_id = '$user_id'");
      if(mysql_num_rows($page_user_down_state)!=0){
        //user ever voted the page down.
        //del the down vote
        mysql_query("DELETE FROM page_user_down WHERE user_id = '$user_id' AND page ='$page'");
        //update page to cancel the user's vote
        mysql_query("UPDATE page SET n_down = n_down-1 WHERE page = '$page'");
		mysql_query("UPDATE domain SET n_down = n_down-1 WHERE domain = '$domain'");
        //update user_domain 
        mysql_query("UPDATE domain_user SET n_down = n_down-1 WHERE domain = '$domain' AND user_id = '$user_id' ");
        //update user to know his vote selection
        mysql_query("UPDATE user SET n_down = n_down-1 WHERE user_id = '$user_id'");
        $voterState = 1;
      }
    }else{
      //unvote state
      //update page to get higher vote
      mysql_query("UPDATE page SET n_up = n_up-1 WHERE page = '$page'");
	  mysql_query("UPDATE domain SET n_up = n_up-1 WHERE domain = '$domain'");
      //update user_domain 
      mysql_query("UPDATE domain_user SET n_up = n_up-1 WHERE domain = '$domain' AND user_id = '$user_id' ");
      //update page_user_up
      mysql_query("DELETE FROM page_user_up WHERE user_id = '$user_id' AND page ='$page'");
      //update user to know his vote selection
      mysql_query("UPDATE user SET n_up = n_up-1 WHERE user_id = '$user_id'");		
    }
    return $voterState;
  }
  function decreasePageCnt($up_or_down){
    $user_id = $this->input->post('user_id');
    $page = $this->input->post('page');
    $voterState = 0;
    //get Domain
    $domainArr = mysql_query("SELECT domain FROM page WHERE page.page ='$page'");
    $domainArr = mysql_fetch_array($domainArr);
    $domain = $domainArr[0];
    //prepare domain_user table
    $domain_user = mysql_query("SELECT * FROM domain_user WHERE user_id='$user_id' AND domain='$domain' ");
    if(mysql_num_rows($domain_user)==0){
      mysql_query("INSERT INTO domain_user (domain,user_id)VALUES('$domain','$user_id')");
    }
    if($up_or_down=='up'){
      //update page to get lower vote
      mysql_query("UPDATE page SET n_down = n_down+1 WHERE page = '$page'");
	  mysql_query("UPDATE domain SET n_down = n_down+1 WHERE domain = '$domain'");
      //update user_domain 
      mysql_query("UPDATE domain_user SET n_down = n_down+1 WHERE domain = '$domain' AND user_id = '$user_id' ");
      //update page_user_up
      mysql_query("INSERT INTO page_user_down (page,domain,user_id)VALUE('$page','$domain','$user_id')");
      //update user to know his vote selection
      mysql_query("UPDATE user SET n_down = n_down+1 WHERE user_id = '$user_id'");
      //check page_user_down and del it.
      $page_user_up_state = mysql_query("SELECT page FROM page_user_up WHERE page='$page' AND user_id = '$user_id'");
      if(mysql_num_rows($page_user_up_state)!=0){
        //user ever voted the page down.
        //del the down vote
        mysql_query("DELETE FROM page_user_up WHERE user_id = '$user_id' AND page ='$page'");
        //update page to cancel the user's vote
        mysql_query("UPDATE page SET n_up = n_up-1 WHERE page = '$page'");
		mysql_query("UPDATE domain SET n_up = n_up-1 WHERE domain = '$domain'");
        //update user_domain 
        mysql_query("UPDATE domain_user SET n_up = n_up-1 WHERE domain = '$domain' AND user_id = '$user_id' ");
        //update user to know his vote selection
        mysql_query("UPDATE user SET n_up = n_up-1 WHERE user_id = '$user_id'");
        $voterState = 1;
      }
    }else{
      //update page to get lower vote
      mysql_query("UPDATE page SET n_down = n_down-1 WHERE page = '$page'");
	  mysql_query("UPDATE domain SET n_down = n_down-1 WHERE domain = '$domain'");
      //update user_domain 
      mysql_query("UPDATE domain_user SET n_down = n_down-1 WHERE domain = '$domain' AND user_id = '$user_id' ");
      //update page_user_up
      mysql_query("DELETE FROM page_user_down WHERE user_id = '$user_id' AND page ='$page'");
      //update user to know his vote selection
      mysql_query("UPDATE user SET n_down = n_down-1 WHERE user_id = '$user_id'");		
    }
    return $voterState;
  }  
  function dealWithPageVote(){
    $user_id = $this->input->post('user_id');
    $page = $this->input->post('page');	
    $state='';
    if($user_id!=''&&$page!=''){
      $checkUpState = mysql_query("SELECT * FROM page_user_up WHERE page = '$page' AND user_id='$user_id'");

      if($checkUpState){
        $checkUpState = mysql_num_rows($checkUpState);
        if($checkUpState!=0){
          $state='upselect';
        }
      }
      $checkDownState = mysql_query("SELECT * FROM page_user_down WHERE page = '$page' AND user_id='$user_id'");
      if($checkDownState){
        $checkDownState = mysql_num_rows($checkDownState);
        if($checkDownState!=0){
          $state=$state.'downselect';
        }		
      }
    }
    return $state;
  } 

  function getRecommend(){
    $page = $this->input->post('page');
    $query = $this->db->query("SELECT n_up FROM page WHERE page.page='$page'");
    $userAndAmount = $query->row_array();
    return $userAndAmount;
  }
  function voteStar(){
	$page = $this->input->post('page');
	$clickVote = $this->input->post('clickVote');
	$user_id = $this->input->post('set_user_id');
	$currentTime= date('Y-m-d H:i:s');
	//update page
	mysql_query("UPDATE page SET n_score = n_score+".$clickVote.", n_score_user = n_score_user+1 WHERE page = '$page'");
	//update comment_vote
	mysql_query("INSERT INTO comment_vote (comment_id,user_id,page,vote_score,v_time)VALUE('-1','$user_id','$page','$clickVote','$currentTime')");
	return 1;
  }
}

