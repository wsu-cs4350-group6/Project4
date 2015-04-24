<?php

use Abraham\TwitterOAuth\TwitterOAuth;

$app->get('/authenticate/twitter',function() use ($app){
    session_start();
    
    $connection = new TwitterOAuth('AkhzPyDT2lHOowR25VsFe9GTU', 'CUo5wkJiXoihxyvuDvFK1V5vsgrpExuBGIr6Em0AD9qODVEprr');
    
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => 'http://localhost:8080/authenticated/twitter'));
    
    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    
    var_dump($request_token);
    var_dump($url);
});

$app->get('/authenticated/twitter',function() use($app){
    session_start();
    
    
    $connection = new TwitterOAuth(
        'AkhzPyDT2lHOowR25VsFe9GTU', 
        'CUo5wkJiXoihxyvuDvFK1V5vsgrpExuBGIr6Em0AD9qODVEprr'
    );
    $access_token = $connection->oauth('oauth/access_token',array(
        "oauth_verifier"=>$app->request->get('oauth_verifier'),
        "oauth_token"=>$app->request->get('oauth_token')
    ));
    $connection = new TwitterOAuth(
        'AkhzPyDT2lHOowR25VsFe9GTU', 
        'CUo5wkJiXoihxyvuDvFK1V5vsgrpExuBGIr6Em0AD9qODVEprr',
        $access_token['oauth_token'],
        $access_token['oauth_token_secret']
    );
    
    
    var_dump($connection->get('statuses/user_timeline'));
});