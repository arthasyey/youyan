<?php
class YouYan_Comment_Amount extends CI_Controller {
  function __construct(){
    parent::__construct();
  }
  function index(){
    $dal = $_GET['callback'];
    $link_id_url_map = $_GET['link_id_url_map']; 

    $link_id_count_map = array();

    //var_dump($link_id_url_map);
    foreach($link_id_url_map as $link_id => $url){
      $query = $this->db->query("select n_comments from page where page='$url'");
      if($query->num_rows() == 0)
        $count = 0;
      else{
        $result = $query->row_array();
        $count = $result['n_comments'];
      }
      $link_id_count_map[$link_id] = $count;
    }
    
    echo $dal . '(' . json_encode($link_id_count_map) . ')';
  }

  //verifyDomain
 
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
