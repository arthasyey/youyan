<?php 
session_start();
require_once( '../application/inc/sina_config.php' );
require_once( '../application/sdk/weibooauth.php');
require_once( '../application/sdk/RESTClient.class.php' );
require_once( '../application/sdk/RenRenClient.class.php' );
require_once( '../application/sdk/RenRenOauth.class.php' );
require_once( '../application/inc/renren_config.php' );


if($_REQUEST['task'] == "get_timeline"){
  if($_REQUEST['platform'] == 'sina'){
    $c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['access_token']['oauth_token'] , $_SESSION['access_token']['oauth_token_secret']  );
    $ms  = $c->home_timeline(); // done
    $me = $c->verify_credentials();

    $json_string = json_encode($ms); 
    echo $json_string;
  }

  else if($_REQUEST['platform'] == 'renren'){
    $renren_client = new RenrenClient;
    $renren_client->setSessionKey($_SESSION['renren_session']);

    $friends = $renren_client->POST('feed.get', array('1', '10'));

    echo json_encode($friends);
  }

}



?>
