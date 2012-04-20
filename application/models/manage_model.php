<?php

class Manage_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 域名列表
     */
    function getDomainList() {
        $uid = $_SESSION["uid"];
        if ($uid != '') {
            $sql = "SELECT domain,verified FROM master_domain WHERE master_id = '$uid'";
            $query = $this->db->query($sql);

            $res = array();
            foreach ($query->result_array() as $k => $domain) {
                $sql = "SELECT n_comments FROM domain WHERE domain = '"
                        . $domain['domain'] . "' ORDER BY n_comments";
                $n_comments = GetOne($sql);
                $res[$k]['n_comments'] = $n_comments;
                $res[$k]['verified'] = $domain['verified'];
                $res[$k]['domain'] = $domain['domain'];
            }

            return $res;
        }
    }

    /**
     * 获取网站验证情况
     */
    function getVerify() {
        $uid = $_SESSION["uid"];
        $domain = $_SESSION['showDomain'];
        if ($uid != '' && $domain != '') {
            $state = GetOne("SELECT verified FROM master_domain WHERE master_id='$uid' AND domain ='$domain'");
            if ($state) {
                return $state;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function getArticleByDomain($domain, $page_num) {
        $from_item = intval($from_item);
        $sql = "SELECT * FROM page
	  				WHERE domain = '$domain' ORDER BY time DESC LIMIT $page_num,10";

        return $this->db->query($sql)->result_array();
    }
    
    /**
     * 分页显示
     */
    function domainCommentsPagination() {
        $this->load->library('pagination');
        $currentDomain = $_SESSION['showDomain'];
        $config['base_url'] = SITE_URL . "/manage/comments";
        $sql = "SELECT count(page) as n_pages from page where domain='$currentDomain'";
        $config['total_rows'] = GetOne($sql);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;  
        //        // 表示第 3 段 URL 为当前页数，如 index.php/控制器/方法/页数，如果表示当前页的 URL 段不是第 3 段，请修改成需要的数值。
        $config['prefix'] = '/';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '<div class="clear"></div></div>';
        $config['first_url'] = SITE_URL . "/manage/comments/";
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['next_link'] = 'next';
        $config['prev_link'] = 'prev';
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $config['num_links'] = 2;
        $config['first_tag_open'] = '<span style="display:none">';
        $config['first_tag_close'] = '</span>';
        $config['last_tag_open'] = '<span style="display:none">';
        $config['last_tag_close'] = '</span>';
        $this->pagination->initialize($config);
        $data['results'] = $this->pagination->create_links();
        return $data['results'];
    }
    
    /**
     * 获取基本信息
     */
    function getDomainBasicInformation($domainURL) {
        $query_str = "select * from domain where domain.domain='$domainURL'";
        $query_all_data = $this->db->query($query_str);
        return $query_all_data->result();
    }

    /**
     * 获取活跃用户
     */
    function getFavUser($domainURL) {
        $query_str = $query_str = "SELECT * FROM(SELECT *,count(*) as c FROM comment where domain='$domainURL' AND from_type!='wordpress' GROUP BY comment.user_id)a 
    JOIN user ON user.user_id = a.user_id WHERE a.user_id != 100
	  ORDER BY a.c DESC LIMIT 0,1";
        $query_user_data = $this->db->query($query_str);
        return $query_user_data->result();
    }

    /**
     * 获取最新访问用户
     */
    function getLastVisitedUser($domainURL) {
        $query_str = "SELECT * FROM user join comment ON user.user_id = comment.user_id and comment.domain='$domainURL' ORDER BY comment.time DESC LIMIT 0,30";
        $query_user_data = $this->db->query($query_str);
        return $query_user_data->result();
    }

    /**
     * 获取时间表
     */
    function getTable($timeArea) {
        $domain = $_SESSION['showDomain'];
        $timeLimit = '';
        if ($timeArea == 'all') {
            $query_str = "SELECT time FROM comment       
        WHERE comment.domain='$domain' ORDER BY comment.time";
            $query_data = mysql_query($query_str);
            $timeLimit = mysql_fetch_array($query_data);
            $timeLimit = $timeLimit[0];
            $yearLimit = ((int) substr($timeLimit, 0, 4));
            $monthLimit = ((int) substr($timeLimit, 5, 2));
            $dayLimit = ((int) substr($timeLimit, 8, 2));

            $timeLimitSt = mktime(0, 0, 0, $monthLimit, $dayLimit, $yearLimit);

            $currentTime = time();

            $dayTime = (int) (($currentTime - $timeLimitSt) / (24 * 3600));
            $timeArea = $dayTime;
        }


        if (($timeArea - 1) < 0) {
            $timeArea = 1;
        }
        $startTime = time() - $timeArea * 3600 * 24;
        $bakStr = '[';
        $traceStr = '[';
        for ($i = 0; $i <= ($timeArea - 1); $i++) {
            $inStartTime = date("Y-m-d 00:00:00", $startTime);
            $inNextTime = date("Y-m-d 00:00:00", ($startTime + 3600 * 24));
            $startTime = $startTime + 3600 * 24;

            //get comment amount
            $query_str = "SELECT count(*) FROM comment WHERE domain='$domain' AND to_days(comment.time)>to_days('$inStartTime') AND to_days(comment.time)<=to_days('$inNextTime') AND from_type!='wordpress'";
            $query_data = mysql_query($query_str);
            $rows = mysql_fetch_array($query_data);
            //modify time      
            $day = date("j", $startTime);
            $month = date("n", $startTime);
            $year = date("Y", $startTime);
            $timeAxie = mktime(0, 0, 0, $month, $day, $year);
            if ($rows[0] < 0 || $rows[0] == NULL) {
                $rows[0] = 0;
            }
            $bakStr = $bakStr . '[' . $timeAxie . '000,' . $rows[0] . ']';
            if ($i != $timeArea - 1) {
                $bakStr = $bakStr . ',';
            }

            //get trace amount
            $query_str = "SELECT count(*) FROM page_traceback
					  WHERE page LIKE '%$domain%' AND to_days(page_traceback.time)>to_days('$inStartTime') AND to_days(page_traceback.time)<=to_days('$inNextTime')";
            $query_data = mysql_query($query_str);
            $rows = mysql_fetch_array($query_data);
            //modify time      
            $day = date("j", $startTime);
            $month = date("n", $startTime);
            $year = date("Y", $startTime);
            $timeAxie = mktime(0, 0, 0, $month, $day, $year);
            if ($rows[0] < 0 || $rows[0] == NULL) {
                $rows[0] = 0;
            }
            $traceStr = $traceStr . '[' . $timeAxie . '000,' . $rows[0] . ']';
            if ($i != $timeArea - 1) {
                $traceStr = $traceStr . ',';
            }
        }
        $bakStr = $bakStr . ']';
        $traceStr = $traceStr . ']';

        return $bakStr . '{}' . $traceStr;
    }

    /**
     * 改变时间表
     */
    function changeTable($timeArea) {
        $transData = $this->input->post('transData');
        $type = $this->input->post('type');
        $timeLimit = '';
        $currentDomain = $_SESSION['showDomain'];
        if ($timeArea == 'all') {
            $query_str = "SELECT time FROM comment       
        WHERE comment.domain='$currentDomain' ORDER BY comment.time";
            $query_data = mysql_query($query_str);
            $timeLimit = mysql_fetch_array($query_data);
            $timeLimit = $timeLimit[0];
            $yearLimit = ((int) substr($timeLimit, 0, 4));
            $monthLimit = ((int) substr($timeLimit, 5, 2));
            $dayLimit = ((int) substr($timeLimit, 8, 2));
            $timeLimitSt = mktime(0, 0, 0, $monthLimit, $dayLimit, $yearLimit);
            $currentTime = time();
            $dayTime = (int) (($currentTime - $timeLimitSt) / (24 * 3600));
            $timeArea = $dayTime;
        }
        if (($timeArea - 1) < 0) {
            $timeArea = 1;
        }
        $startTime = time() - $timeArea * 3600 * 24;
        $bakStr = '[';
        $traceStr = '[';
        for ($i = 0; $i <= ($timeArea - 1); $i++) {
            $inStartTime = date("Y-m-d 00:00:00", $startTime);
            $inNextTime = date("Y-m-d 00:00:00", ($startTime + 3600 * 24));
            $startTime = $startTime + 3600 * 24;

            //get comment amount
            switch ($type) {
                case 'sns':
                    $query_str = "SELECT count(*) FROM comment
        			WHERE comment.from_type = '$transData' AND comment.domain = '$currentDomain' AND to_days(comment.time)>to_days('$inStartTime') AND to_days(comment.time)<=to_days('$inNextTime') AND from_type !='wordpress' ";
                    break;
                case 'user':
                    $query_str = "SELECT count(*) FROM comment
        			WHERE comment.user_id ='$transData' AND comment.domain = '$currentDomain' AND to_days(comment.time)>to_days('$inStartTime') AND to_days(comment.time)<=to_days('$inNextTime') AND from_type !='wordpress'";
                    break;
                case 'allComment':
                    $query_str = "SELECT count(*) FROM comment
        			WHERE comment.page ='$transData' AND comment.domain = '$currentDomain' AND to_days(comment.time)>to_days('$inStartTime') AND to_days(comment.time)<=to_days('$inNextTime') AND from_type !='wordpress'";
                    break;
                case 'comment':
                    $query_str = "SELECT count(*) FROM comment
        			WHERE comment.comment_id ='$transData' AND comment.domain = '$currentDomain' AND to_days(comment.time)>to_days('$inStartTime') AND to_days(comment.time)<=to_days('$inNextTime') AND from_type !='wordpress'";
                    break;
                default:
                    $query_str = "SELECT count(*) FROM comment
        			WHERE comment.page ='$transData' AND to_days(comment.time)>to_days('$inStartTime') AND to_days(comment.time)<=to_days('$inNextTime') AND from_type !='wordpress'";
                    break;
            }



            $query_data = mysql_query($query_str);
            $rows = mysql_fetch_array($query_data);
            //modify time      
            $day = date("j", $startTime);
            $month = date("n", $startTime);
            $year = date("Y", $startTime);
            $timeAxie = mktime(0, 0, 0, $month, $day, $year);
            if ($rows[0] < 0 || $rows[0] == NULL) {
                $rows[0] = 0;
            }
            $bakStr = $bakStr . '[' . $timeAxie . '000,' . $rows[0] . ']';
            if ($i != $timeArea - 1) {
                $bakStr = $bakStr . ',';
            }
            //get trace amount
            switch ($type) {
                case 'sns':
                    $query_str = "SELECT count(*) FROM page_traceback
					    WHERE from_type ='$transData' AND to_days(page_traceback.time)>to_days('$inStartTime') AND to_days(page_traceback.time)<=to_days('$inNextTime') AND domain = '$currentDomain'";
                    break;
                case 'user':
                    $query_str = "SELECT count(*) FROM page_traceback
					  WHERE user_id ='$transData' AND to_days(page_traceback.time)>to_days('$inStartTime') AND to_days(page_traceback.time)<=to_days('$inNextTime') AND domain = '$currentDomain'";
                    break;
                case 'allComment':
                    $query_str = "SELECT count(*) FROM page_traceback
					  WHERE page ='$transData' AND to_days(page_traceback.time)>to_days('$inStartTime') AND to_days(page_traceback.time)<=to_days('$inNextTime') ";
                    break;
                case 'comment':
                    $query_str = "SELECT count(*) FROM page_traceback
					  WHERE comment_id ='$transData' AND to_days(page_traceback.time)>to_days('$inStartTime') AND to_days(page_traceback.time)<=to_days('$inNextTime') ";
                    break;
                default:
                    $query_str = "SELECT count(*) FROM page_traceback
					  WHERE page='$transData' AND to_days(page_traceback.time)>to_days('$inStartTime') AND to_days(page_traceback.time)<=to_days('$inNextTime')";
                    break;
            }

            $query_data = mysql_query($query_str);
            $rows = mysql_fetch_array($query_data);
            //modify time      
            $day = date("j", $startTime);
            $month = date("n", $startTime);
            $year = date("Y", $startTime);
            $timeAxie = mktime(0, 0, 0, $month, $day, $year);
            if ($rows[0] < 0 || $rows[0] == NULL) {
                $rows[0] = 0;
            }
            $traceStr = $traceStr . '[' . $timeAxie . '000,' . $rows[0] . ']';
            if ($i != $timeArea - 1) {
                $traceStr = $traceStr . ',';
            }
        }
        $bakStr = $bakStr . ']';
        $traceStr = $traceStr . ']';
        return $bakStr . '{}' . $traceStr;
    }

    /**
     * 分页显示
     */
    function domainTracePagination($type) {
        $this->load->library('pagination');
        $currentDomain = $_SESSION['showDomain'];
        switch ($type) {
            case 'user':
                $query_str = mysql_query("SELECT DISTINCT user_id from comment where domain='$currentDomain'");
                $query_str = mysql_num_rows($query_str);
                $itemAmount = $query_str;
                $config['base_url'] = site_url('youyan_admin_trace_user');
                break;

            case 'comment':
                $query_str = mysql_query("SELECT count(comment_id) as comment_amount from comment where domain='$currentDomain'");
                $query_str = mysql_fetch_array($query_str);
                $itemAmount = $query_str["comment_amount"];
                $config['base_url'] = site_url('youyan_admin_trace_comment');
                break;

            default:
                $query_str = mysql_query("SELECT DISTINCT page as comment_amount from comment where domain='$currentDomain'");
                $query_str = mysql_num_rows($query_str);
                $itemAmount = $query_str;
                $config['base_url'] = site_url('youyan_admin_trace');
                break;
        }

        $config['total_rows'] = $itemAmount;
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;  // 表示第 3 段 URL 为当前页数，如 index.php/控制器/方法/页数，如果表示当前页的 URL 段不是第 3 段，请修改成需要的数值。
        $config['prefix'] = 'index/';
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '<div class="clear"></div></div>';
        $config['first_url'] = $config['base_url'] . "/index/";
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['next_link'] = '下一页';
        $config['prev_link'] = '上一页';
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $data['results'] = $this->pagination->create_links();
        return $data['results'];
    }

    function createCSS() {
        $css = $_REQUEST['css'];
        $type = $_REQUEST['type'];
        if ($type == 'comment') {
            $docName = 'user_css/comment/' . $_SESSION['showDomain'] . '.css';
        } else if ($type == 'article') {
            $docName = 'user_css/article/' . $_SESSION['showDomain'] . '.css';
        } else {
            $docName = 'user_css/' . $_SESSION['showDomain'] . '.css';
        }

        file_put_contents($docName, $css);
        return $docName;
    }

    function createCSSCrossDomain() {
        $css = $_REQUEST['css'];
        $domain = $_REQUEST['domain'];
        $docName = 'user_css/' . $domain . '.css';
        file_put_contents($docName, $css);
        return $docName;
    }

    function updateLimitAmount() {
        $limitAmount = $this->input->post('limitAmount');
        $masterID = $_SESSION["uid"];
        $state = mysql_query("UPDATE master SET max_email = '$limitAmount' WHERE master_id = '$masterID'");
        return 1;
    }

    function updateLimitAmountCross($limitAmount, $masterID) {
        $state = mysql_query("UPDATE master SET max_email = '$limitAmount' WHERE master_id = '$masterID'");
        return 1;
    }

    function getTracePages($domainURL, $from_item) {
        $query_str = "select n_comments, page_title, traceamount, b.page from page join
      (SELECT count(*) as traceamount, page_traceback.page FROM page_traceback WHERE page_traceback.domain='$domainURL' GROUP BY page_traceback.page)b on page.page=b.page ORDER BY traceamount DESC  LIMIT $from_item,20";
        $query_data = $this->db->query($query_str);
        return $query_data->result();
    }

    function getTraceDomain($domainURL) {
        $query_str = "select domain.n_comments_all, domain.n_comments, traceamount, domain.domain from domain left join
      (SELECT count(*) as traceamount, domain FROM page_traceback WHERE domain = '$domainURL' GROUP BY domain)b on domain.domain=b.domain WHERE domain.domain = '$domainURL'";
        $query_data = $this->db->query($query_str);
        return $query_data->result();
    }

    function getTraceUsers($domainURL, $from_item) {
        $query_str = "SELECT * FROM
      (SELECT user.*, domain_user.n_comments_all AS usercommentamount FROM user JOIN domain_user on user.user_id=domain_user.user_id where domain_user.domain='$domainURL')a left JOIN
      (SELECT page_traceback.user_id, count(*) as traceamount FROM page_traceback  where page_traceback.domain = '$domainURL' GROUP BY page_traceback.user_id)b ON a.user_id = b.user_id 
      ORDER BY b.traceamount DESC  LIMIT $from_item,10";

        $query_data = $this->db->query($query_str);
        return $query_data->result();
    }

    function getTraceComment($domainURL, $from_item) {
        $query_str = "SELECT * FROM comment
						   LEFT JOIN (SELECT *,count(*) as traceamount FROM page_traceback GROUP BY page_traceback.comment_id)b ON b.comment_id = comment.comment_id	
						   LEFT JOIN user ON user.user_id = comment.user_id						   	
						   WHERE comment.domain = '$domainURL' ORDER BY b.traceamount DESC  LIMIT $from_item,20";

        $query_data = $this->db->query($query_str);
        return $query_data->result();
    }

    function getTraceSNS($domainURL, $from_item) {
        $query_str = "  SELECT * from domain join
                    (SELECT from_type, domain, count(traceid) as traceamount FROM page_traceback where domain = '$domainURL' GROUP BY from_type)b ON b.domain = domain.domain
                    ORDER BY traceamount DESC";
        $query_data = $this->db->query($query_str);
        return $query_data->result();
    }

    function createShareLink() {
        $page = $this->input->post('page');
        $secretStr = md5($page . time());
        $ts_create = date('Y-m-d H:i:s');
        $query_str = "INSERT INTO sharelink (page,secret_str,ts_create)VALUE('$page','$secretStr','$ts_create')";
        $query_data = $this->db->query($query_str);
        return "http://uyan.cc/index.php/youyan_admin_temp/index/" . $secretStr;
    }

    function checkSecret($secret_str) {
        $query_str = mysql_query("SELECT * FROM sharelink 
							   	LEFT JOIN page ON page.page = sharelink.page
								WHERE secret_str = '$secret_str'");
        $result_amount = mysql_num_rows($query_str);
        if ($result_amount == 0) {
            return 0;
        } else {
            $pageArr = mysql_fetch_array($query_str);
            return $pageArr;
        }
    }

    function getDomainByPage($page) {
        $query_str = mysql_query("SELECT * FROM comment WHERE page = '$page'");
        $pageArr = mysql_fetch_array($query_str);
        return $pageArr;
    }

    function getWebBox() {
        $domain = $this->input->post('domain');
        $query_str = mysql_query("SELECT * FROM domain WHERE domain = '$domain'");
        $domainArr = mysql_fetch_array($query_str);
        return $domainArr;
    }

    function getWebBoxUser() {
        $domain = $this->input->post('domain');

        $key = 'WebBoxUser_' . $domain;
        $result = $this->mem->get($key);
        $resultArr = array();

        if ($result !== false) {
            $resultArr = $result;
        } else {
            $query_str = mysql_query("SELECT *,domain_user.n_comments as real_comments FROM domain_user
								   LEFT JOIN user ON user.user_id = domain_user.user_id
								   WHERE domain_user.domain = '$domain' ORDER BY domain_user.n_comments DESC LIMIT 0,10");
            $i = 0;
            while ($row = mysql_fetch_array($query_str)) {
                $domainArr[$i] = $row;
                $i++;
            }
            $resultArr['active'] = $domainArr;
            $query_str = mysql_query("SELECT *,domain_user.n_up_received as real_up FROM domain_user
								   LEFT JOIN user ON user.user_id = domain_user.user_id
								   WHERE domain_user.domain = '$domain' ORDER BY domain_user.n_up_received DESC LIMIT 0,10");
            $n = 0;
            while ($row = mysql_fetch_array($query_str)) {
                $domainArr[$n] = $row;
                $n++;
            }
            $resultArr['like'] = $domainArr;

            $this->mem->set($key, $resultArr, 3600);
        }
        return $resultArr;


        //OLD
        $domain = $this->input->post('domain');

        $query_str = mysql_query("SELECT *,domain_user.n_comments as real_comments FROM domain_user
							   LEFT JOIN user ON user.user_id = domain_user.user_id
							   WHERE domain_user.domain = '$domain' ORDER BY domain_user.n_comments DESC LIMIT 0,10");
        $i = 0;

        while ($row = mysql_fetch_array($query_str)) {
            $domainArr[$i] = $row;
            $i++;
        }
        $result_arr['active'] = $domainArr;

        $query_str = mysql_query("SELECT *,domain_user.n_up_received as real_up FROM domain_user
							   LEFT JOIN user ON user.user_id = domain_user.user_id
							   WHERE domain_user.domain = '$domain' ORDER BY domain_user.n_up_received DESC LIMIT 0,10");
        $n = 0;
        while ($row = mysql_fetch_array($query_str)) {
            $domainArr[$n] = $row;
            $n++;
        }
        $result_arr['like'] = $domainArr;
        return $result_arr;
    }

    function savePluginSetting() {
        $itemAmount = $this->input->post('itemAmount');
        $type = $this->input->post('type');
        $showHeadNum = $this->input->post('showHeadNum');
        $configWidth = $this->input->post('configWidth');
        $strValueA = $this->input->post('strValueA');
        $changePeriod = $this->input->post('changePeriod');
        $domain = $_SESSION['domain_data']['domain'];
        switch ($type) {
            case 'hotCommentSetting':
                $_SESSION['domain_data']['commentHotAmount'] = $itemAmount;
                $_SESSION['domain_data']['commentHotHead'] = $showHeadNum;
                $_SESSION['domain_data']['commentHotWidth'] = $configWidth;
                $_SESSION['domain_data']['commentHotPeriod'] = $changePeriod;
                $type = 'commentHotAmount';
                $updateHead = 1;
                $updateStr = 'commentHotHead';
                $updateWidth = 'commentHotWidth';
                $updatePeriod = 1;
                $updatePeriodStr = 'commentHotPeriod';
                break;
            case 'timeCommentSetting':
                $_SESSION['domain_data']['commentTimeAmount'] = $itemAmount;
                $_SESSION['domain_data']['commentTimeHead'] = $showHeadNum;
                $_SESSION['domain_data']['commentTimeWidth'] = $configWidth;
                $type = 'commentTimeAmount';
                $updateHead = 1;
                $updateStr = 'commentTimeHead';
                $updateWidth = 'commentTimeWidth';
                break;
            case 'hotArticleSetting':
                $_SESSION['domain_data']['articleHotAmount'] = $itemAmount;
                $_SESSION['domain_data']['articleHotWidth'] = $configWidth;
                $_SESSION['domain_data']['articleHotPeriod'] = $changePeriod;
                $type = 'articleHotAmount';
                $updateWidth = 'articleHotWidth';
                $updatePeriod = 1;
                $updatePeriodStr = 'articleHotPeriod';
                break;
            default:
                $_SESSION['domain_data']['articleTimeAmount'] = $itemAmount;
                $_SESSION['domain_data']['articleTimeWidth'] = $configWidth;
                $type = 'articleTimeAmount';
                $updateWidth = 'articleTimeWidth';
                break;
        }
        $_SESSION['domain_data']['listTitle'] = $strValueA;
        mysql_query("UPDATE domain SET " . $type . "='$itemAmount', " . $updateWidth . "='$configWidth', listTitle='$strValueA' WHERE domain ='$domain'");
        if ($updateHead == 1) {
            mysql_query("UPDATE domain SET " . $updateStr . "='$showHeadNum' WHERE domain ='$domain'");
        }
        if ($updatePeriod == 1) {
            mysql_query("UPDATE domain SET " . $updatePeriodStr . "='$changePeriod' WHERE domain ='$domain'");
        }
        return 1;
    }

    function fixLikeNum() {
        $updateInfo = mysql_query("SELECT sum(n_up) as upnum, sum(n_down) as downnum,page.domain as domainOut FROM page GROUP BY domain");
        while ($row = mysql_fetch_array($updateInfo)) {
            $upnum = $row['upnum'];
            $downnum = $row['downnum'];
            $domain = $row['domainOut'];
            mysql_query("UPDATE domain SET domain.n_up = '$upnum',domain.n_down = '$downnum' WHERE domain.domain ='$domain'");
        }
    }

    function saveBlackList() {
        $value = $this->input->post('value');
        $type = $this->input->post('type');
        $domain = $_SESSION['domain_data']['domain'];
        $state = mysql_query("SELECT * FROM domain_spam WHERE domain = '$domain'");
        if (mysql_num_rows($state) == 0) {
            $insertValue = $value . ',';
            mysql_query("INSERT INTO domain_spam (domain," . $type . ")VALUE('$domain','$insertValue')");
        } else {
            $row = mysql_fetch_array($state);
            $lastValue = $row[$type];
            $insertValue = $lastValue . $value . ',';

            mysql_query("UPDATE domain_spam SET " . $type . "='$insertValue' WHERE domain = '$domain'");
        }
        return 1;
    }

    function saveSpamWords() {
        $value = $this->input->post('value');
        $domain = $_SESSION['domain_data']['domain'];
        $state = mysql_query("SELECT * FROM domain_spam WHERE domain = '$domain'");
        if (mysql_num_rows($state) == 0) {
            mysql_query("INSERT INTO domain_spam (domain,	word)VALUE('$domain','$value')");
        } else {
            mysql_query("UPDATE domain_spam SET word ='$value' WHERE domain = '$domain'");
        }

        $docName = 'spam_words/' . $domain . '.txt';          // Prepare for the spam words files
        $dicName = 'spam_dics/' . $domain;
        $ret = file_put_contents($docName, $value);
        var_dump($ret);
        if (file_exists($docName)) {
            system("./dpp $docName $dicName");

            $key = 'filter_' . $domain;
            $trie_filter = trie_filter_load($dicName);
            $ret = $this->mem->set($key, $trie_filter);
            var_dump($ret);
        }
        return 1;
    }

    function getSpam() {
        $domain = $_SESSION['domain_data']['domain'];
        $result = mysql_query("SELECT * FROM domain_spam WHERE domain = '$domain'");
        $arrayResult = mysql_fetch_array($result);
        return $arrayResult;
    }

    function bakupData() {
        //prepare value
        $domain_post = $_SESSION['domain_data']['domain'];
        $master_id_post = $_SESSION['uid'];
        //get master value
        //createnode
        $dom = new DOMDocument('1.0', 'utf-8');
        $xmlName = 'uyan' . md5(time()) . '.xml';
        $path = "xml/" . $xmlName;
        $module = $dom->createElement('uyan');
        $dom->appendChild($module);
        //basic attribute
        $xmlns = $dom->createAttribute('xmlns');
        $xmlns->nodeValue = 'http://uyan.cc';
        $module->setAttributeNode($xmlns);
        $xsi = $dom->createAttribute('xmlns:xsi');
        $xsi->nodeValue = 'http://www.w3.org/2001/XMLSchema-instance';
        $module->setAttributeNode($xsi);
        //basic attribute
        $category = $dom->createElement('category');
        $masterId = $dom->createElement('masterId');
        $masterId_value = $dom->createTextNode($master_id_post);
        $masterId->appendChild($masterId_value);
        $category->appendChild($masterId);

        $domain = $dom->createElement('domain');
        $domain_value = $dom->createTextNode($domain_post);
        $domain->appendChild($domain_value);
        $category->appendChild($domain);
        $module->appendChild($category);

        $postItem = mysql_query("SELECT * FROM comment WHERE domain = '$domain_post'");
        while ($row = mysql_fetch_array($postItem)) {
            $comment_id_post = $row['comment_id'];
            $content_post = $row['content'];
            $time_post = $row['time'];
            $from_type_post = $row['from_type'];
            $page_post = $row['page'];
            $page_url_post = $row['page_url'];
            $page_title_post = $row['page_title'];
            $user_id_post = $row['user_id'];
            $sina_url_post = $row['sina_url'];
            $tencent_t_url_post = $row['tencent_t_url'];
            $sohu_t_url_post = $row['sohu_t_url'];
            $neteasy_t_url_post = $row['neteasy_t_url'];
            $n_up_post = $row['n_up'];
            $n_down_post = $row['n_down'];
            $reply_to_comment_id_post = $row['reply_to_comment_id'];
            $del_post = $row['del'];
            $comment_author_post = $row['comment_author'];
            $comment_author_email_post = $row['comment_author_email'];
            $comment_author_url_post = $row['comment_author_url'];
            $notified_post = $row['notified'];
            $hotness_post = $row['hotness'];
            $IP_post = $row['IP'];
            $wp_import_export_id_post = $row['wp_import_export_id'];
            $sina_trace_id_post = $row['sina_trace_id'];
            $tencent_trace_id_post = $row['tencent_trace_id'];
            $renren_trace_id_post = $row['renren_trace_id'];
            $kaixin_trace_id_post = $row['kaixin_trace_id'];
            $neteasy_trace_id_post = $row['neteasy_trace_id'];
            $sohu_trace_id_post = $row['sohu_trace_id'];
            $qq_trace_id_post = $row['qq_trace_id'];
            $veryfy_status_post = $row['veryfy_status'];

            //posts
            $post = $dom->createElement('post');
            $comment_id = $dom->createAttribute('comment_id');
            $comment_id->nodeValue = $comment_id_post;
            $post->setAttributeNode($comment_id);

            if (isset($content_post) && $content_post != '') {
                $content = $dom->createElement('content');
                $content_value = $dom->createCDATASection($content_post);
                $content->appendChild($content_value);
                $post->appendChild($content);
            }

            $time = $dom->createElement('time');
            $time_value = $dom->createTextNode($time_post);
            $time->appendChild($time_value);
            $post->appendChild($time);

            if (isset($from_type_post) && $from_type_post != '') {
                $from_type = $dom->createElement('from_type');
                $from_type_value = $dom->createTextNode($from_type_post);
                $from_type->appendChild($from_type_value);
                $post->appendChild($from_type);
            }
            if (isset($page_post) && $page_post != '') {
                $page = $dom->createElement('page');
                $page_value = $dom->createCDATASection($page_post);
                $page->appendChild($page_value);
                $post->appendChild($page);
            }
            if (isset($page_url_post) && $page_url_post != '') {
                $page_url = $dom->createElement('page_url');
                $page_url_value = $dom->createCDATASection($page_url_post);
                $page_url->appendChild($page_url_value);
                $post->appendChild($page_url);
            }
            if (isset($domain_post) && $domain_post != '') {
                $domain = $dom->createElement('domain');
                $domain_value = $dom->createTextNode($domain_post);
                $domain->appendChild($domain_value);
                $post->appendChild($domain);
            }
            if (isset($page_title_post) && $page_title_post != '') {
                $page_title = $dom->createElement('page_title');
                $page_title_value = $dom->createCDATASection($page_title_post);
                $page_title->appendChild($page_title_value);
                $post->appendChild($page_title);
            }
            if (isset($user_id_post) && $user_id_post != '') {
                $user_id = $dom->createElement('user_id');
                $user_id_value = $dom->createTextNode($user_id_post);
                $user_id->appendChild($user_id_value);
                $post->appendChild($user_id);
            }
            if (isset($sina_url_post) && $sina_url_post != '') {
                $sina_url = $dom->createElement('sina_url');
                $sina_url_value = $dom->createTextNode($sina_url_post);
                $sina_url->appendChild($sina_url_value);
                $post->appendChild($sina_url);
            }
            if (isset($tencent_t_url_post) && $tencent_t_url_post != '') {
                $tencent_t_url = $dom->createElement('tencent_t_url');
                $tencent_t_url_value = $dom->createTextNode($tencent_t_url_post);
                $tencent_t_url->appendChild($tencent_t_url_value);
                $post->appendChild($tencent_t_url);
            }
            if (isset($sohu_t_url_post) && $sohu_t_url_post != '') {
                $sohu_t_url = $dom->createElement('sohu_t_url');
                $sohu_t_url_value = $dom->createTextNode($sohu_t_url_post);
                $sohu_t_url->appendChild($sohu_t_url_value);
                $post->appendChild($sohu_t_url);
            }
            if (isset($neteasy_t_url_post) && $neteasy_t_url_post != '') {
                $neteasy_t_url = $dom->createElement('neteasy_t_url');
                $neteasy_t_url_value = $dom->createTextNode($neteasy_t_url_post);
                $neteasy_t_url->appendChild($neteasy_t_url_value);
                $post->appendChild($neteasy_t_url);
            }
            if (isset($n_up_post) && $n_up_post != '') {
                $n_up = $dom->createElement('n_up');
                $n_up_value = $dom->createTextNode($n_up_post);
                $n_up->appendChild($n_up_value);
                $post->appendChild($n_up);
            }
            if (isset($n_down_post) && $n_down_post != '') {
                $n_down = $dom->createElement('n_down');
                $n_down_value = $dom->createTextNode($n_down_post);
                $n_down->appendChild($n_down_value);
                $post->appendChild($n_down);
            }
            if (isset($reply_to_comment_id_post) && $reply_to_comment_id_post != '') {
                $reply_to_comment_id = $dom->createElement('reply_to_comment_id');
                $reply_to_comment_id_value = $dom->createTextNode($reply_to_comment_id_post);
                $reply_to_comment_id->appendChild($reply_to_comment_id_value);
                $post->appendChild($reply_to_comment_id);
            }
            if (isset($del_post) && $del_post != '') {
                $del = $dom->createElement('del');
                $del_value = $dom->createTextNode($del_post);
                $del->appendChild($del_value);
                $post->appendChild($del);
            }
            if (isset($comment_author_post) && $comment_author_post != '') {
                $comment_author = $dom->createElement('comment_author');
                $comment_author_value = $dom->createTextNode($comment_author_post);
                $comment_author->appendChild($comment_author_value);
                $post->appendChild($comment_author);
            }
            if (isset($comment_author_email_post) && $comment_author_email_post != '') {
                $comment_author_email = $dom->createElement('comment_author_email');
                $comment_author_email_value = $dom->createTextNode($comment_author_email_post);
                $comment_author_email->appendChild($comment_author_email_value);
                $post->appendChild($comment_author_email);
            }
            if (isset($comment_author_url_post) && $comment_author_url_post != '') {
                $comment_author_url = $dom->createElement('comment_author_url');
                $comment_author_url_value = $dom->createTextNode($comment_author_url_post);
                $comment_author_url->appendChild($comment_author_url_value);
                $post->appendChild($comment_author_url);
            }
            if (isset($notified_post) && $notified_post != '') {
                $notified = $dom->createElement('notified');
                $notified_value = $dom->createTextNode($notified_post);
                $notified->appendChild($notified_value);
                $post->appendChild($notified);
            }
            if (isset($hotness_post) && $hotness_post != '') {
                $hotness = $dom->createElement('hotness');
                $hotness_value = $dom->createTextNode($hotness_post);
                $hotness->appendChild($hotness_value);
                $post->appendChild($hotness);
            }
            if (isset($IP_post) && $IP_post != '') {
                $IP = $dom->createElement('IP');
                $IP_value = $dom->createTextNode($IP_post);
                $IP->appendChild($IP_value);
                $post->appendChild($IP);
            }
            if (isset($wp_import_export_id_post) && $wp_import_export_id_post != '') {
                $wp_import_export_id = $dom->createElement('wp_import_export_id');
                $wp_import_export_id_value = $dom->createTextNode($wp_import_export_id_post);
                $wp_import_export_id->appendChild($wp_import_export_id_value);
                $post->appendChild($wp_import_export_id);
            }
            if (isset($sina_trace_id_post) && $sina_trace_id_post != '') {
                $sina_trace_id = $dom->createElement('sina_trace_id');
                $sina_trace_id_value = $dom->createTextNode($sina_trace_id_post);
                $sina_trace_id->appendChild($sina_trace_id_value);
                $post->appendChild($sina_trace_id);
            }
            if (isset($tencent_trace_id_post) && $tencent_trace_id_post != '') {
                $tencent_trace_id = $dom->createElement('tencent_trace_id');
                $tencent_trace_id_value = $dom->createTextNode($tencent_trace_id_post);
                $tencent_trace_id->appendChild($tencent_trace_id_value);
                $post->appendChild($tencent_trace_id);
            }
            if (isset($renren_trace_id_post) && $renren_trace_id_post != '') {
                $renren_trace_id = $dom->createElement('renren_trace_id');
                $renren_trace_id_value = $dom->createTextNode($renren_trace_id_post);
                $renren_trace_id->appendChild($renren_trace_id_value);
                $post->appendChild($renren_trace_id);
            }
            if (isset($kaixin_trace_id_post) && $kaixin_trace_id_post != '') {
                $kaixin_trace_id = $dom->createElement('kaixin_trace_id');
                $kaixin_trace_id_value = $dom->createTextNode($kaixin_trace_id_post);
                $kaixin_trace_id->appendChild($kaixin_trace_id_value);
                $post->appendChild($kaixin_trace_id);
            }
            if (isset($neteasy_trace_id_post) && $neteasy_trace_id_post != '') {
                $neteasy_trace_id = $dom->createElement('neteasy_trace_id');
                $neteasy_trace_id_value = $dom->createTextNode($neteasy_trace_id_post);
                $neteasy_trace_id->appendChild($neteasy_trace_id_value);
                $post->appendChild($neteasy_trace_id);
            }
            if (isset($sohu_trace_id_post) && $sohu_trace_id_post != '') {
                $sohu_trace_id = $dom->createElement('sohu_trace_id');
                $sohu_trace_id_value = $dom->createTextNode($sohu_trace_id_post);
                $sohu_trace_id->appendChild($sohu_trace_id_value);
                $post->appendChild($sohu_trace_id);
            }
            if (isset($qq_trace_id_post) && $qq_trace_id_post != '') {
                $qq_trace_id = $dom->createElement('qq_trace_id');
                $qq_trace_id_value = $dom->createTextNode($qq_trace_id_post);
                $qq_trace_id->appendChild($qq_trace_id_value);
                $post->appendChild($qq_trace_id);
            }
            if (isset($veryfy_status_post) && $veryfy_status_post != '') {
                $veryfy_status = $dom->createElement('veryfy_status');
                $veryfy_status_value = $dom->createTextNode($veryfy_status_post);
                $veryfy_status->appendChild($veryfy_status_value);
                $post->appendChild($veryfy_status);
            }
            $module->appendChild($post);
        }
        $dom->save($path);

        $master_info = mysql_query("SELECT * FROM master WHERE master_id = '$master_id_post'");
        $master_info = mysql_fetch_array($master_info);
        $subject = '您的评论备份文件 -- 来自友言';
        $mailContent = '您好 ' . $master_info['nick'] . ',<br/><br/>您的评论备份数据已生成，请右键存储此文件。<br/><a href="http://uyan.cc/' . $path . '" target="_blank">http://uyan.cc/' . $path . '</a><br/><br/>友言网<br/>help@uyan.cc';
        /* 	  echo $master_info['email'];
          echo $master_info['nick'];
          echo $mailContent;
          echo $subject */
        $this->smtp_xml_mail($master_info['email'], $master_info['nick'], $mailContent, $subject);

        return 1;
    }

    function delBlackSpam() {
        $value = $this->input->post('value');
        $type = $this->input->post('type');
        if ($type == 'user_id') {
            $valueArr = split(':', $value);
            $value = $valueArr[1];
        }
        $domain = $_SESSION['domain_data']['domain'];
        $state = mysql_query("SELECT * FROM domain_spam WHERE domain = '$domain'");
        $row = mysql_fetch_array($state);
        $targetStr = $row[$type];

        $newStr = str_replace($value . ',', '', $targetStr);
        mysql_query("UPDATE domain_spam SET " . $type . " = '$newStr' WHERE domain = '$domain'");

        return 1;
    }

    function getRestPassword($resetMd5) {
        $resetMd5 = $this->post_check($resetMd5);
        $backData = mysql_query("SELECT * FROM getpw 
							   LEFT JOIN master ON getpw.uid = master.master_id
							   WHERE checkcombine = '$resetMd5'");
        $backAmount = mysql_num_rows($backData);
        if ($backAmount < 1)
            return 1;
        $backArr = mysql_fetch_array($backData);
        return $backArr['email'];
    }

    function smtp_xml_mail($sendto_email, $user_name, $content, $subject) {
        require_once("phpmailer/class.phpmailer.php");
        $body = $content;
        $mail = new PHPMailer();
        $mail->IsSMTP(); // send via SMTP 	
        $mail->CharSet = "UTF-8";
        //$mail->Encoding = "base64";	
        $mail->Host = "127.0.0.1"; // SMTP servers 
        $mail->Port = 25;
        $mail->SMTPAuth = false; // turn on SMTP authentication 
        $mail->Username = "root"; // SMTP username
        $mail->Password = "youyan"; // SMTP password 
        $mail->From = 'admin@uyan.cc'; // 发件人邮箱
        $mail->FromName = '友言客服'; // 发件人
        $mail->AddAddress($sendto_email, $user_name); // 收件人邮箱和姓名
        $mail->AddReplyTo("admin", "uyan.cc");
        $mail->IsHTML(true); // send as HTML
        // 邮件主题
        $mail->Subject = htmlspecialchars($subject);
        // 邮件内容
        $mail->Body = $body;
        $mail->AltBody = "text/html";
        if (!$mail->Send()) {
            return 0;
        } else {
            return 1;
        }
    }

    function getCommentAmount($url) {
        if ($url == '')
            return 0;
        $url = urldecode($url);
        $url_arr = explode('{_}', $url);
        $result = '';
        foreach ($url_arr as $row) {
            if ($row != '') {
                $state = mysql_query("SELECT n_comments FROM page WHERE page = '$row'");
                $state = mysql_fetch_array($state);
                $result = $result . '_' . $state['n_comments'];
            }
        }
        return $result;
    }

    function getNotification() {
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        $limit = $this->input->post('limit');
        if ($limit >= 3) {
            $limitStr = 'limit 0,3';
        } else {
            $limitStr = 'limit 0,' . $limit;
        }

        //temp 


        if ($type == 'notification') {
            mysql_query("UPDATE user SET noti = 0 WHERE user_id ='$user_id'");
            $result = "select * FROM notification WHERE user_id= '$user_id' order by c_time DESC " . $limitStr;
            $query_data = $this->db->query($result);
            return $query_data->result();
        } else {
            mysql_query("UPDATE user SET noti_article = 0 WHERE user_id ='$user_id'");
            $result = "select * FROM domain_user
		  			 LEFT JOIN domain ON domain.domain = domain_user.domain 
					 WHERE domain_user.user_id= '$user_id' AND unread>0 order by unread DESC " . $limitStr;
            $query_data = $this->db->query($result);
            mysql_query("UPDATE domain_user SET unread = 0 WHERE user_id ='$user_id'");
            return $query_data->result();
        }
    }

    function getNotificationMain($user_id) {
        mysql_query("UPDATE user SET noti = 0 WHERE user_id ='$user_id'");
        $result = "select * FROM notification WHERE user_id= '$user_id' AND type='reply' order by c_time desc limit 0,30";
        $query_data = $this->db->query($result);
        return $query_data->result();
    }

    function getNotificationLike($user_id) {
        mysql_query("UPDATE user SET noti = 0 WHERE user_id ='$user_id'");
        $result = "select * FROM notification WHERE user_id= '$user_id' AND type='voteUp' order by c_time desc limit 0,30";
        $query_data = $this->db->query($result);
        return $query_data->result();
    }

    function getNotificationNews($user_id) {
        mysql_query("UPDATE user SET noti_article = 0 WHERE user_id ='$user_id'");
        $domainList = mysql_query("select group_concat(domain) FROM domain_user		  			 
					 WHERE domain_user.user_id= '$user_id'");
        $domainList = mysql_fetch_array($domainList);
        $domainList = $this->post_check($domainList[0]);
        //get news
        $resultList = "SELECT * FROM page 
	  				LEFT JOIN domain on domain.domain = page.domain
					WHERE FIND_IN_SET(page.domain,'$domainList')>=1 ORDER BY page.time DESC LIMIT 0,30";


        $query_data = $this->db->query($resultList);
        mysql_query("UPDATE domain_user SET unread = 0 WHERE user_id ='$user_id'");
        return $query_data->result();
    }

    function getNotification_article() {
        $user_id = $this->input->post('user_id');
        $domainSelect = $this->input->post('domainSelect');
        $limit = $this->input->post('limit');
        if ($limit > 3) {
            $limitstr = "limit 0, 3";
        } else {
            $limitstr = "limit 0, " . $limit;
        }
        $result = "SELECT * FROM page WHERE domain = '$domainSelect' ORDER BY time DESC " . $limitstr;
        $query_data = $this->db->query($result);
        return $query_data->result();
    }

    function getNotificationList($user_id) {
        $query = mysql_query("SELECT *,domain.domain as domain_t FROM domain_user
			  LEFT JOIN domain ON domain.domain = domain_user.domain 
			  WHERE user_id ='$user_id' ORDER BY unread DESC");
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $domain = $row['domain_t'];
            $arryInner = mysql_query("SELECT * FROM page WHERE domain = '$domain' ORDER BY time DESC LIMIT 0,3");
            $m = 0;
            while ($inrow = mysql_fetch_array($arryInner)) {
                $innerContent[$m] = $inrow;
                $m++;
            }
            $callback[$i] = $row;
            $i++;
        }
        return $callback;
    }

    function userAddToBlack() {
        $user_id = $this->input->post('user_id');
        $user_email = $this->input->post('user_email');
        $user_name = $this->input->post('user_name');
        $user_domain = $this->input->post('user_domain');
        $domain = $_SESSION['domain_data']['domain'];

        if ($user_id != '' && $user_id != 100) {
            $inserValue = $user_id . ',';
            $state = mysql_query("SELECT * FROM domain_spam WHERE domain = '$domain'");
            if (mysql_num_rows($state) == 0) {
                mysql_query("INSERT INTO domain_spam (domain, user_id)VALUE('$domain','$inserValue')");
            } else {
                $currentUid = $state['user_id'];
                $currentUid = str_replace($user_id . ',', '', $currentUid);
                $currentUid = $currentUid . $user_id . ',';
                mysql_query("UPDATE domain_spam SET user_id ='$currentUid' WHERE domain = '$domain'");
            }
        } else {
            $state = mysql_query("SELECT * FROM domain_spam WHERE domain = '$domain'");

            if (mysql_num_rows($state) == 0) {
                if (trim($user_email) == '' || $user_email . length <= 0) {
                    $emailStr = '';
                    $emailStrA = '';
                } else {
                    $emailStr = ',email';
                    $emailStrA = ",'" . $user_email . ",'";
                }
                $user_name = $user_name . ',';
                mysql_query("INSERT INTO domain_spam (domain, user_name" . $emailStr . ")VALUE('$domain','$user_name'" . $emailStrA . ")");
            } else {
                $state = mysql_fetch_array($state);
                //email part
                if (trim($user_email) != '' && $user_email != NULL) {
                    $currentEmail = $state['email'];
                    if (trim($currentEmail) != '' && $currentEmail != NULL) {
                        $currentEmail = str_replace($user_email . ',', '', $currentEmail);
                        $currentEmail = $currentEmail . $user_email . ',';
                    } else {
                        $currentEmail = $user_email . ',';
                    }
                    $emailStr = "email ='" . $currentEmail . "',";
                } else {
                    $emailStr = '';
                }

                //user_name part
                $currentUserName = $state['user_name'];
                if (trim($currentUserName) != '' && $currentUserName != NULL) {
                    $currentUserName = str_replace($user_name . ',', '', $currentUserName);
                    $currentUserName = $currentUserName . $user_name . ',';
                } else {
                    $currentUserName = $user_name . ',';
                }

                mysql_query("UPDATE domain_spam SET " . $emailStr . " user_name='" . $currentUserName . "' WHERE domain = '$domain'");
            }
        }
    }

    # /*  
    # 函数名称：post_check()  
    # 函数作用：对提交的编辑内容进行处理  
    # 参　　数：$post: 要提交的内容  
    # 返 回 值：$post: 返回过滤后的内容  
    # */    

    function post_check($post) {
        if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否为打开     
            $post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤     
        }
        $post = str_replace("_", "\_", $post);    // 把 '_'过滤掉     
        $post = str_replace("%", "\%", $post);    // 把 '%'过滤掉     
        $post = nl2br($post);    // 回车转换     
        $post = htmlspecialchars($post);    // html标记转换     

        return $post;
    }

}