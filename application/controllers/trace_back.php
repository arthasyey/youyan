<?php
class Trace_BACK extends CI_Controller {
  function __construct(){
    parent::__construct();
  }

  /**
   * 更新统计信息
   */
  function index(){
    $page = $_GET['page'];
    $url = $_GET['url'];
	$user_id = $_GET['user_id'];
	$comment_id = $_GET['comment_id'];
	$from_type = $_GET['from_type'];
	$data = array(
        'page' => $page,
		'user_id' => $user_id,
		'comment_id' => $comment_id,
		'from_type' => $from_type,
        'time' => date('Y-m-d H:i:s')
    );
    $this->db->insert('page_traceback', $data);
	Header("HTTP/1.1 303 See Other");
	Header("Location: ".$url);
	exit;

  }
}
?>
