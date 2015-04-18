<?php

use API\Common\Authentication\SQLiteAccess;

/**
 * @api {get} /access Request Access Key
 * @apiName GetAccess
 * @apiGroup Authenticate
 *
 * @apiSuccess {String} key Access Key
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *        "key": "e618d316-8249-5d7a-8eac-8942f73192d7"
 *     }
 *
 * @apiVersion 0.1.0
 */

$app->get('/access', function() use ($app, $env) {

    $access = new SQLiteAccess();
    $uuid5 = $access->getUUID($env['REMOTE_ADDR']);
    $access->storeUUID($env['REMOTE_ADDR'], $uuid5, $env);
    $access->buildUUIDResponse($app, $uuid5);

});

