<?php
/**
 * File name: IAuthentication.php
 *
 * Project: Project2
 *
 * PHP version 5
 *
 * $LastChangedDate$
 * $LastChangedBy$
 */

namespace API\Common\Authentication;


interface IAuthentication 
{
    /**
     * Function authenticate
     *
     * @param string $username
     * @param string $password
     * @return mixed
     *
     * @access public
     */
    public function authenticate($username, $password);
    /*
    *   @param string $username
    *   @return bool
    */
    public function userExists($username);
}
