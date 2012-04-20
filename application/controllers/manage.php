<?php
class Manage extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if(!islogin()) {
          Header("HTTP/1.1 303 See Other");
          Header("Location:".SITE_URL);
          exit;  
        }
        $this->load->model('Manage_model', 'managemod');
    }
    
    public function index(){
        $domains = $this->managemod->getDomainList();
        $vars = array(
                'domains' => $domains,
                'uname'   => $_SESSION['uname'],
        );

        $this->tpl->assign($vars);
        set_page_title("网站管理");
        $this->tpl->display();
    }
   
    //评论管理
    public function comments($page_num = 0){
        $verify = $this->managemod->getVerify();
        $domain = $_SESSION['showDomain'];
        $articles = $this->managemod->getArticleByDomain($domain, $page_num);
        $pagination = $this->managemod->domainCommentsPagination();
        $vars = array(
            'verify' => $verify,
            'articles' => $articles,
            'pagination' => $pagination,
        );

        $this->tpl->assign($vars);
        set_page_title("评论管理");
        $this->tpl->display('manage/comments.html');
    }
    
    //安装与设置
    public function install_setting(){
        $titleStr = $_SESSION['domain_data']['listTitle'];
        $titleArr = explode('}_{',$titleStr);
        $this->load->model('webdata_model', 'webdatamod');
        $verify = $this->webdatamod->getVerify();
        $vars = array(
                    'domain_data' => $_SESSION['domain_data'],
                    'verify'      => $verify,
                    'titleArr'    => $titleArr,
        );
        $this->tpl->assign($vars);
        set_page_title("安装于设置");
        $this->tpl->display('manage/install_setting.html');        
    }
}