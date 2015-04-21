<?php


use API\Model\User;


$app->get('/user/profile/:id', function($id) use($app){
    $user = User::getUser($id);
    $username = $user['username'];
    $firstName = $user['firstName'];
    $lastName = $user['lastName'];
    $emailAddress = $user['emailAddress'];
    $twitterUsername = $user['twitterUsername'];
    $registrationDate = $user['registrationDate'];
    
    $body = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="all">
</head>
<body>
    <div id='container'>
        <h3>($username) $firstName $lastName</h3>
        <div style='border-top:1px solid #ddd;height:1px;margin:20px 0;'></div>
        
        <h4>registered : $registrationDate</h4>
        <h4>email : $emailAddress</h4>
        <h4>twitter : $twitterUsername</h4>
         
    </div>
</body>
</html>
HTML;

    $app->response->setBody($body);

});