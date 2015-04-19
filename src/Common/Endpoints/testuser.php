<?php

$app->get('/test/user',function() use($app){
    $body = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
    $(function(){
        $('button[type="submit"]').click(function(){
            
            var id = $('input[name="id"]').val();
            $.ajax({
                method:'GET',
                url:'/user/'+id,
            }).done(function(response){
                console.log(response);
                $('#user_response').html(
                    "<h4>User Information</h4>" + 
                    "<ul><li>" + 
                    response.username + 
                    "</li><li>tw: " + 
                    response.twitterUsername + 
                    "</li><li>" + 
                    response.firstName + 
                    "</li><li> " + 
                    response.lastName + 
                    "</li><li>" + 
                    response.emailAddress + 
                    "</li><li>" + 
                    response.registrationDate + 
                    "</li></ul>" 
                );
            }).fail(function(jqXHR, textStatus){
                $('#user_response').html("Error: " + jqXHR.status);
            });
            return false;
        });
    });
    </script>
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="all">
</head>
<body>
    <div id='registration'>
        <h3>User Test</h3>
        <form >
            <div class='row'>
                <input type='text' name='id' placeholder='id'/>
                <button type='submit'>Submit</button>
            </div>
        </form>
        <div style='border-top:1px solid #ddd;height:1px;margin:20px 0;'></div>
        <div id='user_response'>
            
        </div>
    </div>
</body>
    
</html>
        

HTML;
    $app->response->setBody($body);
});