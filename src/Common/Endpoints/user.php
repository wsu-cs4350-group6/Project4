<?php
use API\Model\User;
/**
 * @api {get} /user/{id} Get a user
 * @apiName User
 * @apiGroup Authenticate
 *
 * @apiSuccess {JSON} location url of new user
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *        "username"        : "example",
 *        "firstName"       : "First",
 *        "lastName"        : "Last",
 *        "emailAddress"    : "example@example.com",
 *        "twitterUsername" : "someTwitterName",
 *        "registrationDate": "YYYY-MM-DD"
 *     }
 *
 * @apiVersion 0.1.0
 */
$app->get('/user/:id',function($id) use($app)
{
    $user = User::getUser($id);
    
    $app->response->setStatus(404);
    $app->response->setBody(json_encode(array('User Does Not Exist'=>'User does not exist')));
    
    if($user)
    {
        $app->response->setStatus(200);
        $app->response->header("Content-Type","application/json");
        $app->response->setBody(json_encode($user));
    }
});