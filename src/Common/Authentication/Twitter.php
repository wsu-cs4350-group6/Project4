<?php
/**
 * Created by PhpStorm.
 * User: Darin
 * Date: 4/9/2015
 * Time: 8:07 PM
 */

namespace API\Common\Authentication;


class Twitter implements IAuthentication {

    /**
     * Function authenticate
     *
     * @param string $username
     * @param string $password
     * @return mixed
     *
     * @access public
     */
    public function authenticate($username, $password)
    {
        // TODO: Implement authenticate() method.
    }

    public function userExists($username)
    {
        // TODO: Implement userExists() method.
    }
}