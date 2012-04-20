
<?php
//session_start();
//
//

/**
 * 处理跟插件相关的请求
 */
class YouYan_Wp_Content extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('comment_model');
  }

  function import_wp_comments(){
    $this->comment_model->import_wp_comments();
  }

  function export_wp_comments(){
    $this->comment_model->export_wp_comments();
  }
  
  function import_wp_to_uyan_comments(){
    $this->comment_model->import_wp_to_uyan_comments();
  }

  /**
   * 获取评论数
   */
  function get_num_comments(){
    $page = $_POST['page'];
    $id = $_POST['id'];
    $page .= $id;

    $query = $this->db->query("select n_comments_all from page where page='$page'");
    if($query->num_rows() > 0){
      $row = $query->row_array();
      //var_dump($row);
      echo $row['n_comments_all'];
      //echo ' find it ';
    }
    else
      echo 0;
  }


  /**
   * 获取新浪应用信息：APP KEY/SECRET ACCESS TOKEN/SECRET
   */
  function get_sina_app_info(){
    $domain = $_POST['domain'];
    $query = $this->db->query("select SINA_APP_KEY, SINA_APP_SECRETE, SINA_ACCESS_TOKEN, SINA_ACCESS_SECRETE from domain where domain='$domain'");
    if($query->num_rows() < 0)
      echo -1;
    else
      echo json_encode($query->row_array());
  }


  /**
   * 获取腾讯应用信息：APP KEY/SECRET ACCESS TOKEN/SECRET
   */
  function get_tencent_app_info(){
    $domain = $_POST['domain'];
    $query = $this->db->query("select TENCENT_APP_KEY, TENCENT_APP_SECRETE, TENCENT_ACCESS_TOKEN, TENCENT_ACCESS_SECRETE from domain where domain='$domain'");
    if($query->num_rows() < 0)
      echo -1;
    else
      echo json_encode($query->row_array());
  }


  /**
   * 发表文章新浪微薄
   */
  function post_wordpress_sina(){
    $page = $_POST['page'];
    $sinaurl = $_POST['sinaurl'];
    $mid = $_POST['mid'];

    $this->db->where('page', $page)->where('sinaurl', $sinaurl)->from('page_sinaurl_time');
    if($this->db->count_all_results() == 0){
      $data = array(
        'page' => $page,
        'sinaurl' => $sinaurl
      );
      $ret = $this->db->insert('page_sinaurl_time', $data);
    }

    $this->db->where('page', $page)->from('page_mid');
    if($this->db->count_all_results() == 0){
      $data = array(
        'page' => $page,
        'sina_mid' => $mid
      );
      $this->db->insert('page_mid', $data);
    }
    else
      $this->db->set('sina_mid', $mid)->where('page', $page)->update('page_mid');
  }


  /**
   * 发表文章腾讯微薄
   */
  function post_wordpress_tencent(){
    $page = $_POST['page'];
    $mid = $_POST['mid'];

    if($mid == '')
      return;

    $page = $_POST['page'];
    $mid = $_POST['mid'];
    $this->db->where('page', $page)->from('page_tencentmid_time');
    if($this->db->count_all_results() == 0){
      $data = array(
        'page' => $page,
        'tencent_mid' => $mid,
        'comment_id' => 0
      );
      $this->db->insert('page_tencentmid_time', $data);
      var_dump($data);
    }

    $this->db->where('page', $page)->from('page_mid');
    if($this->db->count_all_results() == 0){
      $data = array(
        'page' => $page,
        'tencent_mid' => $mid
      );
      $this->db->insert('page_mid', $data);
    }
    else
      $this->db->set('tencent_mid', $mid)->where('page', $page)->update('page_mid');
  }


  /**
   * 检查是否发表过文章腾讯微薄（防止重复）
   */
  function checkAlreadyPublishedTencent(){
    $this->db->where('page', $_REQUEST['page'])->from('page_mid');
    if($this->db->count_all_results() == 0)
      echo 'not';
    else{
      $query = $this->db->where('page', $_REQUEST['page'])->from('page_mid')->select('tencent_mid')->get();
      $query_row = $query->row_array();
      if($query_row['tencent_mid'] == '')
        echo 'not';
      else
        echo 'yes';
    }
  }
}

?>
