<?php
namespace API\Model;
use PDO;

class User
{
    protected $username;
    protected $password;
    
    /*
    * @param string $username
    * @param string $password
    */
    function __construct($username,$password)
    {
        $this->username = $username;
        $this->password = md5($password);
        
    }
    
    /*
    * @return boolean
    */
    public static function exists($username)
    {
        $exists = FALSE;
        try
        {
            $dbh = new PDO('sqlite:'.User::getApp()->sqliteFile);
            $sql = "SELECT id,username from users where username=:username";
        
            $statement = $dbh->prepare($sql);
            $statement->execute(array(':username'=>$username));
            $exists = $statement->fetch();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        return $exists;
    }
    
    /*
    * @return mixed?
    */
    public static function getApp()
    {
        return \Slim\Slim::getInstance();
    }
    
    /*
    * @return boolean
    */
    public function save()
    {
        // Save should have an update function, but don't know how to implement that yet
        if(User::exists($this->username))
        {
            return FALSE;
        }
        
        $success = FALSE;
        
        try
        {
            $dbh = new PDO('sqlite:'.User::getApp()->sqliteFile);
            $sql = "INSERT INTO users (username,password) values(:username,:password)";
            $statement = $dbh->prepare($sql);
            if($statement)
            {
                $success = $statement->execute(array(
                    ':username' => $this->username,
                    ':password' => $this->password
                ));
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        
        return $success;
        
    }
}