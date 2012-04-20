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
    if (!get_magic_quotes_gpc()) {    // �ж�magic_quotes_gpc�Ƿ�Ϊ��     
      $post = addslashes($post);    // ����magic_quotes_gpcû�д򿪵�������ύ���ݵĹ���     
    }     
    $post = str_replace("_", "\_", $post);    // �� '_'���˵�     
    $post = str_replace("%", "\%", $post);    // �� '%'���˵�     
    $post = nl2br($post);    // �س�ת��     
    $post = htmlspecialchars($post);    // html���ת��

    return $post;     
  }
  //end
}
?>
