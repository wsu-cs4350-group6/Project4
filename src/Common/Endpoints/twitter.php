<?php
/**
 * Created by PhpStorm.
 * User: dcritchlow
 * Date: 4/12/15
 * Time: 7:21 PM
 */

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', $env['config']['app']['twitter']['consumer_key']);
define('CONSUMER_SECRET', $env['config']['app']['twitter']['consumer_secret']);
define('OAUTH_CALLBACK', $env['config']['app']['twitter']['oauth_callback']);

$app->get('/twitter', function() use ($app, $env) {

    $twitter = new \API\Common\Authentication\Twitter();
    print_r($twitter->oauth($env));

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    echo '<pre>';
    print_r($connection);
    echo '</pre>';

    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
    echo '<pre>';
    print_r($request_token);
    echo '</pre>';

});
