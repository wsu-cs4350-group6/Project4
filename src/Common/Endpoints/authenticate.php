<?php

use API\Common\Authentication\DataBaseAuthentication;
use API\Common\Authentication\SQLiteAccess;

/**
 * @api {post} /authenticate Authenticate User
 * @apiHeader {String} Authorization Unique access key
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Authorization": "e618d316-8249-5d7a-8eac-8942f73192d7"
 *     }
 * @apiName AuthenticateUser
 * @apiGroup Authenticate
 *
 * @apiSuccess (200) {json} Location url for user profile
 *
 * @apiSuccessExample {json} Success-Response:
 *     HTTP/1.1 200 OK
 *  {
 *      "Location": "/user/{id}"
 *  }
 *
 * @apiError (302) UserNotFound Username was not found, gives link to registration page.
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 302 Found
 *     {
 *       "UserNotFound": "/register"
 *     }
 *
 * @apiError (401) NoAccessKey Access key was not included.
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "NoAccessKey": "You must have an access key"
 *     }
 *
 * @apiError (401) InvalidAccessKey Access key was not valid.
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "InvalidAccessKey": "You must have a valid access key"
 *     }
 *
 * @apiError (401) NoUserName Missing username in POST.
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "NoUserName": "You must have a valid username parameter"
 *     }
 *
 * @apiError (401) NoPassword Missing password in POST.
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "NoPassword": "You must have a valid password parameter"
 *     }
 *
 * @apiError (401) InvalidCredentials Invalid username and password combination.
 *
 * @apiErrorExample {json} Error-Response:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "InvalidCredentials": "Invalid username:password"
 *     }
 *
 * @apiVersion 0.1.0
 */

$app->post('/authenticate',function() use ($app, $env){
    $access = new SQLiteAccess();
    $uuid = $app->request->headers['Authorization'];

    if(!$uuid)
    {
        $app->response->setStatus(401);
        $body = array('NoAccessKey' => 'You must have an access key');
        $app->response->setBody(json_encode($body));
        return;
    }
    if(!$access->checkUUID($uuid, $env))
    {
        $app->response->setStatus(401);
        $body = array('InvalidAccessKey' => 'You must have a valid access key');
        $app->response->setBody(json_encode($body));
        return;
    }
    if(!$app->request->params('username'))
    {
        $app->response->setStatus(401);
        $body = array('NoUserName' => 'You must have a valid username parameter');
        $app->response->setBody(json_encode($body));
        return;
    }
    if(!$app->request->params('password'))
    {
        $app->response->setStatus(401);
        $body = array('NoPassword' => 'You must have a valid password parameter');
        $app->response->setBody(json_encode($body));
        return;
    }

    $authEngine = new DataBaseAuthentication($env);

    $result = $authEngine->authenticate($app->request->post('username'),$app->request->post('password'));

    if (isset($result['body']['UserNotFound'])){
        $app->response->setStatus(302);
        $app->response->setBody(json_encode($result['body'], JSON_UNESCAPED_SLASHES));
        return;
    }

    $app->response->setStatus($result['status']);

    $app->response->setBody(json_encode($result['body'], JSON_UNESCAPED_SLASHES));

});