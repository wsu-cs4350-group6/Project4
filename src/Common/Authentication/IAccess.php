<?php
/**
 * Created by PhpStorm.
 * User: dcritchlow
 * Date: 4/5/15
 * Time: 7:23 PM
 */

namespace API\Common\Authentication;


interface IAccess
{
    /**
     * @param $remoteAddress
     * @return Uuid|string
     */
    public function getUUID($remoteAddress);

    /**
     * @param $app
     * @param $uuid
     */
    public function buildUUIDResponse($app, $uuid);

    /**
     * @param $remoteAddress
     * @param $uuid
     * @param $env
     */
    public function storeUUID($remoteAddress, $uuid, $env);

    /**
     * @param $uuid
     * @param $env
     * @return result|boolean
     */
    public function checkUUID($uuid, $env);
}