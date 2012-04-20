<?php

class Getpwd extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Password_model', 'pwdmod');
    }

    public function index() {
        set_page_title("找回密码");
        $this->tpl->display();
    }

    public function reset($reset_id) {
        $ret = $this->pwdmod->getRestPassword($reset_id);
        if($ret == ''){
             showerror('对不起，确认码错误，请重新找回密码！');
             exit();
        }elseif($ret == 'timeout'){
             showerror('对不起，该链接已失效，请重新找回密码！');
             exit();
        }
        $vars = array(
            'email' => $ret,
            'reset_id' => $reset_id,
        );
        
        $this->tpl->assign($vars);
        set_page_title("重置密码");
        $this->tpl->display("getpwd/reset.html");
    }

    public function resetPassword() {
        echo $this->pwdmod->resetPassword();
    }

    public function resetPasswordDone() {
        echo $this->pwdmod->resetPasswordDone();
    }

}