<?php
//session_start();
require(APPPATH. '/inc/config.php');
class YouYan_Content extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('comment_model');
  }

  /**
   * 检查某用户是否顶过某评论
   */
  
  function checkUp(){
    echo $this->comment_model->checkUp();
  }

  /**
   * 检查某用户是否踩过某评论
   * */
  function checkDown(){
    echo $this->comment_model->checkDown();
  }

  /**
   * 获取本页评论数
   */
  function getCommentsCNT(){
    //echo 1;
    echo $this->comment_model->getCommentsCNT();
  }

  /**
   * 发表回复
   */
  function postReply(){
    $this->comment_model->postComment();
  }

  /**
   * 发表评论
   */
  function postComment(){
    $this->comment_model->postComment();
  }

  /**
   * 发表评论后续工作（更新数据库等）
   */
  function postCommentPostWork(){
    $this->comment_model->postCommentPostWork();
  }

  /**
   * 获取评论
   */
  function getComments($order_by = 'time'){
    $query_result = $this->comment_model->getComments($order_by);
    echo json_encode($query_result);
  }

  /**
   * 获取页面顶和踩推荐
   */
  function getRecommend(){
    $this->load->model('vote_model');
    $query_result = $this->vote_model->getRecommend();
    echo json_encode($query_result);
  }

  /**
   * 获取多个评论的回复（使用）
   */
  function getRepliesTogether($order_by = 'time'){
    $query_result = $this->comment_model->getRepliesTogether($order_by);
    echo json_encode($query_result);
  }

  /**
   * 获取单个评论的回复（没有使用）
   */
  function getReplies($order_by = 'time'){
    $query_result = $this->comment_model->getReplies($order_by);
    echo json_encode($query_result);
  }

  /**
   * 增加本页面顶或踩计数
   */
  function increasePageCnt($up_or_down){
    $this->load->model('vote_model');
    echo $this->vote_model->increasePageCnt($up_or_down);
  }

  /**
   * 处理顶和踩页面
   */
  function dealWithPageVote(){
    $this->load->model('vote_model');
    echo $this->vote_model->dealWithPageVote();
  }

  /**
   * 减少本页面顶或踩计数
   */
  function decreasePageCnt($up_or_down){
    $this->load->model('vote_model');
   	echo  $this->vote_model->decreasePageCnt($up_or_down);
  }

  /**
   * 增加某评论顶或踩计数
   */
  function increaseCnt($up_or_down){
    $this->comment_model->increaseCnt($up_or_down);
  }

  /**
   * 减少某评论顶或踩计数
   */
  function decreaseCnt($up_or_down){
    $this->comment_model->decreaseCnt($up_or_down);
  }

  /**
   * 删除评论
   */
  function delComment($commentId){
    $this->comment_model->delComment($commentId);	  
  }

  /**
   * 将某一评论的verify_status置为0（正常）
   */
  function accessComment($commentId){
	 $this->comment_model->accessComment($commentId); 
  }

  /**
   * 没有使用
   */
  function getReplyComment($ruid){
	echo json_encode($this->comment_model->getReplyComment($ruid));
  }

  /**
   * 获取用户profile信息
   */
  function getUserProfile(){
    $this->load->model('user_model');
	echo json_encode($this->user_model->getUserProfile());
  }

  /**
   * 获取网站信息
   */
  function getUserProfileSocial(){
    $this->load->model('user_model');
	echo json_encode($this->user_model->getUserProfileSocial());
  }

  /**
   * 获取弹出的用户窗口（包括最新评论，活跃社区）
   */
  function getWebBox(){
    $this->load->model('webdata_model');
	echo json_encode($this->webdata_model->getWebBox());
  }

  /**
   * 获取网站的活跃用户
   */
  function getWebBoxUser(){
    $this->load->model('webdata_model');
	echo json_encode($this->webdata_model->getWebBoxUser());	  
  }
  
  /**
   * 获取消息通知（回复，顶踩）
   */
  function getNotification(){
    $this->load->model('webdata_model');
	echo json_encode($this->webdata_model->getNotification());	  
  }

  /**
   * 获取新文章消息通知
   */
  function getNotification_article(){
    $this->load->model('webdata_model');
	echo json_encode($this->webdata_model->getNotification_article());		  
  }

  /**
   * 打分
   */
  function voteStar(){
    $this->load->model('vote_model');
	echo json_encode($this->vote_model->voteStar());		  
  }
}
