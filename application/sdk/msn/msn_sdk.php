<?php 
require_once APPPATH . 'inc/msn_config.php';

/* Example callback URL:
http://www.contoso.com/callback.php
?code=8f61a46f-717c-793a-ee27-bdfe33153b25

Example acquire tokens URL using authorization code:
https://oauth.live.com/token?
client_id=00000000603DB0FC
&redirect_uri=http%3A%2F%2Fwww.contoso.com%2Fcallback.php
&client_secret=MLWILlT555GicSrIATma5qgyBXebRIKT
&code=8f61a46f-717c-793a-ee27-bdfe33153b25
&grant_type=authorization_code

Example acquire tokens URL using refresh token:
https://oauth.live.com/token?
client_id=00000000603DB0FC
&redirect_uri=http%3A%2F%2Fwww.contoso.com%2Fcallback.php
&client_secret=MLWILlT555GicSrIATma5qgyBXebRIKT
&refresh_token=LA9Y...full refresh token omitted for brevity...xRoX
&grant_type=refresh_token
*/    
function getTokens($clientID, $redirectURI, $clientSecret, $refreshToken = null, $authorizationCode = null) {
    
    if (isset($authorizationCode)) {
        $getTokensURL = ENDPOINT_OAUTH . ENDPOINT_PATH_TOKEN .
            PARAM_CLIENT_ID . $clientID .
            PARAM_REDIRECT_URI . $redirectURI . 
            PARAM_CLIENT_SECRET . $clientSecret .
            PARAM_CODE . $authorizationCode .
            PARAM_GRANT_TYPE . PARAM_GRANT_TYPE_AUTHORIZATION_CODE;
    }
    elseif (isset($refreshToken)) {
        $getTokensURL = ENDPOINT_OAUTH . ENDPOINT_PATH_TOKEN .
            PARAM_CLIENT_ID . $clientID .
            PARAM_REDIRECT_URI . $redirectURI .
            PARAM_CLIENT_SECRET . $clientSecret .
            PARAM_REFRESH_TOKEN . $refreshToken . 
            PARAM_GRANT_TYPE . PARAM_GRANT_TYPE_REFRESH_TOKEN;
    }
    else {
        logMessage('Error retrieving tokens. Cannot determine whether to use ' . 
            'refresh token or verification code.');
            return false;
    }
            
    //logMessage('Request URL for token(s): ' . $getTokensURL);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $getTokensURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    if (isset($GLOBALS['DISABLE_SSL_CHECKING'])) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }

    $json = curl_exec($ch);

    if (curl_errno($ch)) {
        logMessage('Error retrieving tokens: ' . curl_error($ch));
        return false;
    }

    $decodedJSON = json_decode($json, true);
        
    //logMessage('Response for tokens request:');
    $info = curl_getinfo($ch);
    //logMessage(var_dump($info));
    //logMessage(var_dump($decodedJSON));    

    curl_close($ch);

    if (array_key_exists('error', $decodedJSON)) {
    
        /*logMessage('Error retrieving tokens: ');

        if (array_key_exists('message', $decodedJSON)) {
            logMessage($decodedJSON['error']['message']);
        }
        else {
            logMessage($decodedJSON['error_description']);
        }*/
        
        return false;
    }
    
    return $decodedJSON;
}

/* Example REST API URL:
https://apis.live.net/v5.0/me/
?oauth_token=EwCo......EkAA

Example REST API GET call:
var_dump(callRestApi(
    'EwCo...full access token omitted for brevity...EkAA', 
    REST_PATH_ME . REST_PATH_CONTACTS, 
    REST_API_GET);

Example REST API POST call:
$activityData = array('message' => 'Explore  Live Connect',
    'link' => 'http://explore.live.com/home',
    'description' => 'Stay in touch and share your world: email, photos, movies, video chat, and more!',
    'picture' => 'http://res2.explore.live.com/resbox/en/Live%20Explore/Main/a/1/a1ce31bd-6291-42fb-9b51-b4cf2013481c/a1ce31bd-6291-42fb-9b51-b4cf2013481c.jpg',
    'name' => 'Live Connect Home'
);
$jsonActivityData = json_encode($activityData);
    
var_dump(callRestApi(
    'EwCo...part of access token omitted for brevity...EkAA', 
    REST_PATH_ME . REST_PATH_SHARE, 
    REST_API_POST, 
    array('Content-Type: application/json'), 
    $jsonActivityData));
*/
function callRestApi($accessToken, $restPath, $requestMethod, $headers = NULL, $methodData = NULL) {
    $restApiURL = ENDPOINT_REST_API . ENDPOINT_REST_API_VERSION . 
        $restPath .    PARAM_ACCESS_TOKEN . $accessToken;
    
    //logMessage('Request URL for REST API: ' . $restApiURL);

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $restApiURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
    
    if (isset($GLOBALS['DISABLE_SSL_CHECKING'])) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
        
    switch ($requestMethod) {
        case REST_API_GET: 
            curl_setopt($ch, CURLOPT_HTTPGET, true);                        
            break;
        case REST_API_POST: 
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $methodData);
            break;
        default:
            logMessage('Error calling REST API. Cannot determine whether to ' .
                'use GET or POST request method.');
            return false;
    }
    
    $json = curl_exec($ch);
    
    if (curl_errno($ch)) {
        //logMessage('Error retrieving data from REST API: ' . curl_error($ch));
        return false;
    }

    $decodedJSON = json_decode($json, true);
    
    //logMessage('Response from REST API:');
    $info = curl_getinfo($ch);
    //logMessage(var_dump($info));
    //logMessage(var_dump($decodedJSON));

    curl_close($ch);

    if (array_key_exists('error', $decodedJSON)) {
    
        logMessage('Error retrieving data from REST API: ');

        if (array_key_exists('message', $decodedJSON['error'])) {
            logMessage($decodedJSON['error']['message']);
        }
        else {
            logMessage($decodedJSON['error_description']);
        }
        
        return false;
    }
    else {
        return $decodedJSON;
    }
    
}




