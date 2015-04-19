<?php
namespace API\Model;
use PDO;

class User
{
    protected $username;
    protected $password;
    protected $firstName;
    protected $lastName;
    protected $emailAddress;
    protected $twitterUsername;
    protected $registrationDate;
    
    
    /*
    * @param string $username
    * @param string $password
    */
    function __construct($username,$password,$firstName,$lastName,$emailAddress,$twitterUsername)
    {
        date_default_timezone_set("America/Denver");
        
        $this->username = $username;
        $this->password = md5($password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddress = $emailAddress;
        $this->twitterUsername = $twitterUsername;
        $this->registrationDate = date('Y-m-d');
        
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
            $sql = "INSERT INTO users (username,password,firstName,lastName,emailAddress,twitterUsername,registrationDate) values(:username,:password,:firstName,:lastName,:emailAddress,:twitterUsername,:registrationDate)";
            $statement = $dbh->prepare($sql);
            if($statement)
            {
                $success = $statement->execute(array(
                    ':username'         => $this->username,
                    ':password'         => $this->password,
                    ':firstName'        => $this->firstName,
                    ':lastName'         => $this->lastName,
                    ':emailAddress'     => $this->emailAddress,
                    ':twitterUsername'  => $this->twitterUsername,
                    ':registrationDate' => $this->registrationDate
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