<?php
define('APP_CLIENT_ID', '0000000044067E10');
define('APP_CLIENT_SECRET', 'YyCLIm67U74M6GxpWbffBoXsTQC-SsXR');
define('APP_REDIRECT_URI', 'http%3A%2F%2Fuyan.cc%2Findex.php%2Fmsn_callback');

define('ENDPOINT_OAUTH', 'https://oauth.live.com/');
define('ENDPOINT_PATH_AUTHORIZE', 'authorize?');
define('ENDPOINT_PATH_TOKEN', 'token?');

define('ENDPOINT_REST_API', 'https://apis.live.net/');
define('ENDPOINT_REST_API_VERSION', 'v5.0/');

define('PARAM_CODE', '&code=');
define('PARAM_CLIENT_ID', 'client_id=');
define('PARAM_CLIENT_SECRET', '&client_secret=');
define('PARAM_GRANT_TYPE', '&grant_type=');
define('PARAM_GRANT_TYPE_AUTHORIZATION_CODE', 'authorization_code');
define('PARAM_GRANT_TYPE_REFRESH_TOKEN', 'refresh_token');
define('PARAM_REDIRECT_URI', '&redirect_uri=');
define('PARAM_REFRESH_TOKEN', '&refresh_token=');
define('PARAM_RESPONSE_TYPE', '&response_type=');
define('PARAM_RESPONSE_TYPE_CODE', 'code');
define('PARAM_ACCESS_TOKEN', '?access_token=');

define('PARAM_SCOPE', '&scope=');
define('PARAM_SCOPE_WL', 'wl.');
define('PARAM_SCOPE_SIGNIN','signin');
define('PARAM_SCOPE_BASIC','basic');
define('PARAM_SCOPE_POSTAL_ADDRESSES','postal_addresses');
define('PARAM_SCOPE_PHONE_NUMBERS','phone_numbers');
define('PARAM_SCOPE_BIRTHDAY','birthday');
define('PARAM_SCOPE_CONTACTS_BIRTHDAY','contacts_birthday');
define('PARAM_SCOPE_EMAILS','emails');
define('PARAM_SCOPE_EVENTS_CREATE','events_create');
define('PARAM_SCOPE_PHOTOS','photos');
define('PARAM_SCOPE_CONTACTS_PHOTOS','contacts_photos');
define('PARAM_SCOPE_APPLICATIONS','applications');
define('PARAM_SCOPE_APPLICATIONS_CREATE','applications_create');
define('PARAM_SCOPE_WORK_PROFILE','work_profile');
define('PARAM_SCOPE_SHARE','share');
define('PARAM_SCOPE_OFFLINE', 'offline_access');

define('REQUESTED_SCOPES',  PARAM_SCOPE_WL . PARAM_SCOPE_SIGNIN . ' ' . 
    PARAM_SCOPE_WL . PARAM_SCOPE_BASIC . ' ' . 
    PARAM_SCOPE_WL . PARAM_SCOPE_EVENTS_CREATE . ' ' .
    PARAM_SCOPE_WL . PARAM_SCOPE_SHARE . ' ' .     
    PARAM_SCOPE_WL . PARAM_SCOPE_OFFLINE);

define('REST_API_GET', 2);
define('REST_API_POST', 3);

define('REST_PATH_APPLICATIONS', 'applications');
define('REST_PATH_ALBUMS', 'albums');
define('REST_PATH_COMMENTS', 'comments');
define('REST_PATH_CONTACTS', 'contacts');
define('REST_PATH_EVENTS', 'events');
define('REST_PATH_FILES', 'files');
define('REST_PATH_FRIENDS', 'friends');
define('REST_PATH_ME', 'me/');
define('REST_PATH_SHARE', 'me/share');
define('REST_PATH_TAGS', 'tags');

$LOG_MESSAGE_FORMAT = 'HTML';

function logMessage($message) {

    switch ($GLOBALS['LOG_MESSAGE_FORMAT']) {
            case 'HTML':
                echo '<p>' . $message . '<p>';
                break;
            case 'TEXT':
                echo $message;
                break;
            default:                
    }
    
}
?>
