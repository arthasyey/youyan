<?php

class Password_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getRestPassword($reset_id) {
        $ret = '';
        $reset_id = isset($reset_id) ? trim($reset_id) : '';

        $sql = "SELECT * FROM " . tname('getpwd') . " WHERE checkcombine = '$reset_id'";
        $res = GetRow($sql);

        if (empty($res)) {
            $ret = '';
        } else {
            $latestTime = strtotime($res['ts_created']) + 3600 * 24;
            //找回密码链接失效
            if (SITE_TIME > $latestTime) {
                return 'timeout';
            }
            $sql = "SELECT email FROM " . tname('getpwd') . " pw
							   LEFT JOIN master ON pw.uid = master.master_id
							   WHERE checkcombine = '$reset_id'";
            $ret = GetOne($sql);
        }

        return $ret;
    }

    function resetPassword() {
        $email = $this->input->post('email');
        $sql = "SELECT master_id,nick FROM master WHERE email = '$email'";
        $master_info = GetRow($sql);

        if (empty($master_info)) {
            return 'no';
        }

        $master_id = $master_info['master_id'];
        $master_name = $master_info['nick'];
        if ($master_name == '') {
            $master_name = '先生/女士';
        }
        $checkcombinestr = time() . $master_id;
        $checkcombine = md5($checkcombinestr);
        $date = date('Y-m-d H:i:s');
        $this->db->query("INSERT INTO " . tname('getpwd') . " (uid,checkcombine,ts_created)VALUE('$master_id','$checkcombine','$date')");

        $subject = '请重新设置您在友言网的密码';
        $vars = array(
            'master_name' => $master_name,
            'checkcombine' => $checkcombine,
        );

        $this->tpl->assign($vars);
        $mailbody = tpl_fetch('getpwd', 'email_tpl');
        sendmail($email, $subject, $mailbody);
        return 'yes';
    }

    function resetPasswordDone() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $reset_id = $this->input->post('reset_id');
        
        $sql = "SELECT uid FROM " . tname('getpwd') . " WHERE checkcombine = '$reset_id'";
        $uid = GetOne($sql);

        if(empty($uid)){ 
            return 'nouser';
        }
        if ($password == ''){
            return 'nopass';
        }
        $password = md5($password);

        $this->db->query("UPDATE master SET password = '$password' WHERE email= '$email'");
        $this->db->query("DELETE FROM " . tname('getpwd') . " WHERE uid= '$uid'");
        return 'validate';
    }

}