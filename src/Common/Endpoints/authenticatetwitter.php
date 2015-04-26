<?php

use Abraham\TwitterOAuth\TwitterOAuth;



$app->get('/authenticate/twitter',function() use ($app, $env){
    $CONSUMER_KEY       = $env['config']['app']['twitter']['consumer_key'];
    $CONSUMER_SECRET    = $env['config']['app']['twitter']['consumer_secret'];
    $OAUTH_CALLBACK     = $env['config']['app']['twitter']['oauth_callback'];

    session_start();
    
    $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
    
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $OAUTH_CALLBACK));
    
    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    $app->response->setStatus(200);

    $app->response->setBody(json_encode($url, JSON_UNESCAPED_SLASHES));
});

$app->get('/authenticated/twitter',function() use($app, $env){

    $CONSUMER_KEY       = $env['config']['app']['twitter']['consumer_key'];
    $CONSUMER_SECRET    = $env['config']['app']['twitter']['consumer_secret'];

    session_start();
    
    
    $connection = new TwitterOAuth( $CONSUMER_KEY, $CONSUMER_SECRET );

    $access_token = $connection->oauth('oauth/access_token',array(
        "oauth_verifier"=>$app->request->get('oauth_verifier'),
        "oauth_token"=>$app->request->get('oauth_token')
    ));

    $connection = new TwitterOAuth(
        $CONSUMER_KEY,
        $CONSUMER_SECRET,
        $access_token['oauth_token'],
        $access_token['oauth_token_secret']
    );

    $response = $connection->get('statuses/user_timeline');
    $username = $response[0]->user->screen_name;
    $tweets = $connection->get('statuses/user_timeline', array("screen_name" => $username, "&count" => "10"));

    echo "<h4>Tweets from " . $tweets[0]->user->screen_name . "</h4>";
    foreach ($tweets as $tweet)
    {
        echo '  ' . htmlentities($tweet->text) . PHP_EOL .  '<hr>';
    }


//    $app->response->setBody(json_encode($tweets, JSON_UNESCAPED_SLASHES));

});