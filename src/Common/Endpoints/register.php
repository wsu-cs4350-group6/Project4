<?php

use API\Model\User;
/**
 * @api {post} /register Register New User
 * @apiName Register
 * @apiGroup Authenticate
 *
 * @apiSuccess {String} location url of new user
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *        "location": "/user/1"
 *     }
 *
 * @apiVersion 0.1.0
 */
$app->post('/register',function() use($app){
    $username = $app->request->post('username');
    $password = $app->request->post('password');
    
    $user = new User($username,$password);
    
    $app->response->setStatus(401);
    $app->response->setBody(json_encode(array('UsernameExists'=>'Please use another username')));
    
    if($user->save())
    {
        $user_row = User::exists($username);
        $app->response->setStatus(201);
        $app->response->setBody(json_encode(array('Location'=>'/user/'.$user_row['id']),JSON_UNESCAPED_SLASHES));
    }
    
    
});

$app->get('/register',function() use($app){
    $body = <<<HTML
    <!DOCTYPE html>
    <html>
    <body>
        <title>Register</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>
        $(function(){
            $('button[type="submit"]').click(function(){
                var username = $('form input[name="username"]').val()
                var password = $('form input[name="password"]').val()
                $.ajax({
                    method:'POST',
                    url:'/register',
                    data:{'username':username,'password':password}
                }).done(function(msg){
                    $('#registration_response').html(msg);
                }).fail(function(jqXHR, textStatus){
                    $('#registration_response').html("Error: " + jqXHR.status);
                });
                return false;
            });
        });
        </script>
        <link rel="stylesheet" href="/css/style.css" type="text/css" media="all">
    </body>
    <body>
        <div id='registration'>
            <h3>Registration</h3>
            <form action='/register' method='post'>
                <input type='text' name='username' placeholder='username'/>
                <input type='password' name='password' placeholder='password'/>
                <button type='submit'>Submit</button>
            </form>
            <div style='border-top:1px solid #ddd;height:1px;margin:5px 0;'></div>
            <div id='registration_response'>
                test
            </div>
        </div>
    </body>
    </html>
HTML;
    $app->response->setBody($body);
});