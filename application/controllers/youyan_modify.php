<?php

$sns = array(
  'SINA',
  'RENREN',
  'KAIXIN',
  'TENCENT',
  'QQ',
  'SOHU',
  'NETEASY',
  'EMAIL',
  'wordpress'
);

class YouYan_Modify extends CI_Controller {
  function __construct(){
    parent::__construct();
  }
  
  function get_short_url_mbs(){
    require_once(APPPATH . 'inc/sina_config.php');
    require_once(APPPATH . 'sdk/weibooauth.php');
    $c = new WeiboClient( SINA_AKEY , 
      SINA_SKEY , 
      'c97b0cad44607d950090c6e01001992a',
      '8899540ae525a271d0ccd204e580e932' );

    $ret = $c->get_short_url_mbs('http://t.cn/S5HhWE', 1, 1);
    var_dump($ret);
    $comments = $ret['share_statuses'];
    foreach($comments as $comment){
      var_dump($comment);
      echo $comment['id'];
      echo '<br />';
      echo $comment['text'];
      echo '<br />';
      //var_dump($comment);
      echo '<br />';
    }
  }

  function get_short_url_comments(){
    require_once(APPPATH . 'inc/sina_config.php');
    require_once(APPPATH . 'sdk/weibooauth.php');
    $c = new WeiboClient( SINA_AKEY , 
      SINA_SKEY , 
      'c97b0cad44607d950090c6e01001992a',
      '8899540ae525a271d0ccd204e580e932' );

    $ret = $c->get_short_url_comments('http://t.cn/aFBi77', 1, 1);
    $comments = $ret['share_comments'];
    foreach($comments as $comment){
      echo $comment['id'];
      echo '<br />';
      echo $comment['text'];
      echo '<br />';
      //var_dump($comment);
      echo '<br />';
    }
    //var_dump($ret);
  }

  function getSinaShortURL($longURL){
    $longURL = 'http://www.36kr.com/p/66139.html';
    $url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=507593302&url_long=' . $longURL;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $output_json = json_decode($output);
    $short_url =  $output_json[0]->url_short;
    echo $short_url;
    return $short_url;
  }


  function updateCommentTimeLine(){
    require_once(APPPATH . 'inc/sina_config.php');
    require_once(APPPATH . 'sdk/weibooauth.php');

    $c = new WeiboClient( SINA_AKEY , 
      SINA_SKEY , 
      'c97b0cad44607d950090c6e01001992a',
      '8899540ae525a271d0ccd204e580e932' );
    while(1){
      $sql = $this->db->query("Select * from page_sinaurl_time where (to_days(now())) - to_days(page_sinaurl_time.time) < 3 order by time desc");
      $results = $sql->result_array();

      foreach($results as $result){
        $sinaurl = $result['sinaurl'];

        $page = $result['page'];
        $watermark = $result['watermark'];
        $mbs_watermark = $result['mbs_watermark'];
        $comment_id = $result['comment_id'];

        $in_reply_to = $result['comment_id'];

        $page_url_query = $this->db->query("select domain, page_url, page_title from page where page='$page'");
        if($page_url_query->num_rows() == 0){
          continue;
        }
        $page_url_result = $page_url_query->row_array();
        $page_url = $page_url_result['page_url'];
        $domain = $page_url_result['domain'];
        $title = $page_url_result['page_title'];


        /* Crawl down comments with this short url */
        $n_page = 1;
        while(1){
          $url_comments_ret = $c->get_short_url_comments($sinaurl, $n_page, $watermark);

          $url_comments = $url_comments_ret['share_comments'];
          if(count($url_comments) == 0){
            break;
          }

          $n_comments = count($url_comments);
          for($i = 0; $i < $n_comments; $i++){
            $msg = $url_comments[$i];
            if($i == 0 and $n_page == 1){
              $watermark = $msg['id'] + 10000;
              $this->db->where('page', $page)->where('comment_id', $comment_id)->set('watermark', $watermark)->update('page_sinaurl_time');
            }

            $content = $msg['text'];
            $time = $msg['created_at'];

            $new_date = date('Y-m-d H:i:s', strtotime($time));

            $sina_id = $msg['user']['id'];
            $screen_name = $msg['user']['screen_name'];
            $profile_img_url = $msg['user']['profile_image_url'];

            $query = $this->db->where('sina_id', $sina_id)->from('user');
            if($query->count_all_results() == 0){
              $metadata = array(
                'sina_id' => $sina_id,
                'sina_show_name' => $screen_name,
                'sina_profile_img' => $profile_img_url
              );
              $this->load->model('user_model');
              $user_id = $this->user_model->create_user('sina', $metadata);
            }
            else{
              $user_query = $this->db->from('user')->where('sina_id', $sina_id)->select('user_id')->get();
              $user_result = $user_query->row_array();
              $user_id = $user_result['user_id'];
            }

            $data = array(
              'from_type' => 'SINA',
              'page_url' => $page_url,
              'domain' => $domain, 
              'page' => $page,
              'user_id' => $user_id, 
              'content' => $content,
              'time' => $new_date,
              'comment_author' => '',
              'comment_author_email' => '',
              'comment_author_url' => '',
              'IP' => '',
              'wp_import_export_id' => '',
              'postToSNS' => 'false',
              'title' => $title,
              'comment_id' => -1
            );

            if($in_reply_to != 0)
              $data['in_reply_to'] = $in_reply_to;

            $url = "http://uyan.cc/index.php/youyan_content/postComment";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $ret = curl_exec($ch);

            $url = "http://uyan.cc/index.php/youyan_content/postCommentPostWork";
            curl_setopt($ch, CURLOPT_URL, $url);
            $ret = curl_exec($ch);
          }
          $n_page ++;
        }

        /* Crawl down micro-blogs with this short url */
        $n_page = 1;
        while(1){
          $url_mbs_ret = $c->get_short_url_mbs($sinaurl, $n_page, $mbs_watermark);
          $url_comments = $url_mbs_ret['share_statuses'];
          if(count($url_comments) == 0){
            break;
          }

          $n_comments = count($url_comments);
          for($i = 0; $i < $n_comments; $i++){
            $msg = $url_comments[$i];
            if($i == 0 and $n_page == 1){
              $mbs_watermark = $msg['id'] + 10000;
              $this->db->where('page', $page)->where('comment_id', $comment_id)->set('mbs_watermark', $mbs_watermark)->update('page_sinaurl_time');
            }

            
            $content = $msg['text'];
            if(mb_substr($content, '评论于', 'utf-8') != false){
              continue;
            }

            $time = $msg['created_at'];
            $new_date = date('Y-m-d H:i:s', strtotime($time));

            $sina_id = $msg['user']['id'];
            $screen_name = $msg['user']['screen_name'];
            $profile_img_url = $msg['user']['profile_image_url'];
            $query = $this->db->where('sina_id', $sina_id)->from('user');
            if($query->count_all_results() == 0){
              $metadata = array(
                'sina_id' => $sina_id,
                'sina_show_name' => $screen_name,
                'sina_profile_img' => $profile_img_url
              );
              $this->load->model('user_model');
              $user_id = $this->user_model->create_user('sina', $metadata);
            }
            else{
              $user_query = $this->db->from('user')->where('sina_id', $sina_id)->select('user_id')->get();
              $user_result = $user_query->row_array();
              $user_id = $user_result['user_id'];
            }
            $data = array(
              'from_type' => 'SINA',
              'page_url' => $page_url,
              'domain' => $domain, 
              'page' => $page,
              'user_id' => $user_id, 
              'content' => $content,
              'time' => $new_date,
              'comment_author' => '',
              'comment_author_email' => '',
              'comment_author_url' => '',
              'IP' => '',
              'wp_import_export_id' => '',
              'postToSNS' => 'false',
              'title' => $title,
              'comment_id' => -1
            );

            if($in_reply_to != 0)
              $data['in_reply_to'] = $in_reply_to;

            $url = "http://uyan.cc/index.php/youyan_content/postComment";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $ret = curl_exec($ch);

            $url = "http://uyan.cc/index.php/youyan_content/postCommentPostWork";
            curl_setopt($ch, CURLOPT_URL, $url);
            $ret = curl_exec($ch);
          }
          $n_page ++;
        }
      }
      sleep(10*60);
    }
  }

  function updateCommentTimeLineTencent(){
    include_once( APPPATH. 'inc/tencent_config.php');
    include_once( APPPATH. 'sdk/tencent/tencentOAuth.php');
    require_once( APPPATH. 'sdk/tencent/tencentClient.php');

    $tencent_c = new MBApiClient( TENCENT_AKEY , TENCENT_SKEY , '607837fddeab4974ab1705f792b7270a', '3c2b6fca8b7c539c7263e06e5de3c278');
    while(1){
      $sql = $this->db->query("Select * from page_tencentmid_time where (to_days(now())) - to_days(page_tencentmid_time.time) < 3 order by time desc");
      $results = $sql->result_array();

      foreach($results as $result){
        #var_dump($result);
        $tencent_mid = $result['tencent_mid'];
        $page = $result['page'];
        $watermark_mid = $result['watermark_mid'];
        $watermark_time = $result['watermark_time'];
        $in_reply_to = $result['comment_id'];

        $page_url_query = $this->db->query("select domain, page_url, page_title from page where page='$page'");
        if($page_url_query->num_rows() == 0){
          continue;
        }
        $page_url_result = $page_url_query->row_array();
        $page_url = $page_url_result['page_url'];
        $domain = $page_url_result['domain'];
        $title = $page_url_result['page_title'];
        $n_page = 1;

        // Deal with a single tencent mid */
        $hasnext = 0;   // 0 means has next for tencent
        while($hasnext == 0){
          $p = array(
            'reid' => $tencent_mid,
            'n' => 1,
            'flag' => 2,
            'f' => 0
          );
          if($watermark_mid != 0){
            $p['f'] = 1;
            $p['t'] = $watermark_time;
            $p['tid'] = $watermark_mid;
          }

          //var_dump($p);
          $ret = $tencent_c->getReplay($p);
          echo $tencent_mid;
          //var_dump($ret);
          if($ret['errcode'] != 0 || $ret['data'] == null){
            break;
          }
          $ret_data = $ret['data'];
          $timestamp = $ret_data['timestamp'];
          $hasnext = $ret_data['hasnext'];
          $infos = $ret_data['info'];

          //var_dump($infos);
          $total_num = count($infos);
          //echo "number: $total_num <br/>";

          for($i = 0; $i < $total_num; $i++){
            $msg = $infos[$i];
            $content = $msg['text'];
            $time = $msg['timestamp'];
            $new_date = date('Y-m-d H:i:s', $time);

            $nick = $msg['nick'];
            $tencent_id = $msg['name'];
            $profile_img_url = $msg['head'];

            $query = $this->db->where('tencent_id', $tencent_id)->from('user');
            if($query->count_all_results() == 0){
              $metadata = array(
                'tencent_id' => $tencent_id,
                'tencent_show_name' => $nick,
                'tencent_profile_img' => $profile_img_url
              );
              $this->load->model('user_model');
              $user_id = $this->user_model->create_user('tencent', $metadata);
            }
            else{
              $user_query = $this->db->from('user')->where('tencent_id', $tencent_id)->select('user_id')->get();
              $user_result = $user_query->row_array();
              $user_id = $user_result['user_id'];
            }

            $data = array(
              'from_type' => 'TENCENT',
              'page_url' => $page_url,
              'domain' => $domain, 
              'page' => $page,
              'user_id' => $user_id, 
              'content' => $content,
              'time' => $new_date,
              'comment_author' => '',
              'comment_author_email' => '',
              'comment_author_url' => '',
              'IP' => '',
              'wp_import_export_id' => '',
              'postToSNS' => 'false',
              'title' => $title,
              'comment_id' => -1
            );

            if($in_reply_to != 0)
              $data['in_reply_to'] = $in_reply_to;

            $url = "http://uyan.cc/index.php/youyan_content/postComment";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $ret = curl_exec($ch);

            $url = "http://uyan.cc/index.php/youyan_content/postCommentPostWork";
            curl_setopt($ch, CURLOPT_URL, $url);
            $ret = curl_exec($ch);
          }

          $watermark_time = $infos[$total_num - 1]['timestamp'];
          $watermark_mid = $infos[$total_num - 1]['id'];

          if($hasnext != 0){
            $this->db->set('watermark_time', date('Y-m-d H:i:s', $watermark_time))->set('watermark_mid', $watermark_mid)->where('tencent_mid', $tencent_mid)->update('page_tencentmid_time');
          }
        }
      }
      sleep(10*60);
    }
  }
}


?>
