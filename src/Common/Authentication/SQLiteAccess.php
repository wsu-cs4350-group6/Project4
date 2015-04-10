<?php
/**
 * Created by PhpStorm.
 * User: dcritchlow
 * Date: 4/5/15
 * Time: 3:03 PM
 */

namespace API\Common\Authentication;

use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;
use PDO;

class SQLiteAccess implements IAccess
{
    /**
     * @param $remoteAddress
     * @return Uuid|string
     */
    public function getUUID($remoteAddress) {
        try {
            $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, $remoteAddress);
            return $uuid5;
        } catch (UnsatisfiedDependencyException $e) {
            $error =  'Caught exception: ' . $e->getMessage() . "\n";
            return $error;
        }
    }

    /**
     * @param $app
     * @param $uuid
     */
    public function buildUUIDResponse($app, $uuid) {
        $app->response->setstatus(200);
        $app->response->headers->set('Content-Type', 'application/json');
        $response = array('key' => $uuid->toString());
        $app->response->setBody(json_encode($response));
    }

    /**
     * @param $remoteAddress
     * @param $uuid
     * @param $env
     */
    public function storeUUID($remoteAddress, $uuid, $env)
    {
        $sqlite = $env['config']['app']['sqlite'];
        $dbh = new PDO('sqlite:' . $sqlite);
        $sql = 'INSERT into access (UUID, IP) VALUES (:uuid, :ip)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $stmt->bindParam(':ip', $remoteAddress, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $uuid
     * @param $env
     * @return result|boolean
     */
    public function checkUUID($uuid, $env)
    {
        $sqlite = $env['config']['app']['sqlite'];
        $dbh = new PDO('sqlite:' . $sqlite);
        $sql = 'SELECT * FROM access WHERE uuid = :uuid';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

}