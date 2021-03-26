<?php

if (basename($_SERVER['PHP_SELF']) == 'Dao.php') {
    header('Location: index.php');
    exit();
}

require_once 'KLogger.php';

class Dao
{

    // private $host = "us-cdbr-east-03.cleardb.com";
    // private $db = "heroku_31de4dc6b0b0f21";
    // private $user = "b9fdc62d5daa4c";
    // private $password = "de2d254a";
    private $host = "localhost";
    private $db = "mygiftlists";
    private $user = "root";
    private $password = "";

    protected $logger;

    public function __construct()
    {
        $this->logger = new KLogger("log.txt", KLogger::ERROR);
    }

    /**
     * Get connection status
     * returns a boolean
     */
    private function getConnection()
    {
        try {
            $connection = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->password);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->logger->LogDebug("Got a connection");
        } catch (PDOException $e) {
            $error = 'Connection failed ' . $e->getMessage();
            $this->logger->LogError($error);
        }
        return $connection;
    }

    /**
     * Get whether user exists
     * Returns a boolean
     * 
     * @var string user provided email address
     * @var string user provided password
     */
    public function userExists($email, $password)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement
            $q = $connection->prepare("select count(*) as total from userdata where email = :email and password = :password");
            
            //bind params
            $q->bindParam(":email", $email);
            $q->bindParam(":password", $password);
            
            //execute
            $q->execute();

            //grab row
            $row = $q->fetch();

            //return whether row exists
            if ($row['total'] == 1) {
                $this->logger->LogDebug("user found!" . print_r($row, 1));
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    /**
     * Get user id from db
     * 
     * @var string user email
     * @var string user password
     * 
     * @return int user id
     */
    public function userIdentification($email, $password)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement
            $q = $connection->prepare("select * from userdata where email = :email and password = :password");
            
            //bind params
            $q->bindParam(":email", $email);
            $q->bindParam(":password", $password);

            //execute query
            $q->execute();

            //fetch row
            $row = $q->fetch();
            $this->logger->LogDebug("Found user id " . print_r($row, 1));

            //return user id
            return $row['userid'];
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    /**
     * Get user information for profile page
     * 
     * @var int user id
     * 
     * @return array array of user data
     */
    public function getUserInfo($userid)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement
            $q = $connection->prepare("select * from userdata where userid = :userid");

            //bind params
            $q->bindParam(":userid", $userid);
            $q->execute();

            //get row
            $row = $q->fetch();

            //assign info to array
            $retArray = [
                "firstname" => $row['firstname'],
                "lastname" => $row['lastname'],
                "email" => $row['email']
            ];

            //return array
            return $retArray;
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    /**
     * Get user lists from db
     * 
     * @var int user id
     * 
     * @return array array of user list names
     */
    public function getUserLists($userid)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement
            $q = $connection->prepare("select listname from userlists where userid = :userid");
            
            //bind params
            $q->bindParam(":userid", $userid);

            //execute
            $q->execute();

            //grab rows
            $rows = $q->fetchAll(PDO::FETCH_COLUMN);

            //return array
            return $rows;
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    /**
     * Check if user email is already used
     * 
     * @var string user email
     * 
     * @return boolean whether user email exists
     */
    public function emailExists($email)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement
            $q = $connection->prepare("select count(*) as total from userdata where email = :email");
            
            //bind params
            $q->bindParam(":email", $email);
            
            //execute
            $q->execute();

            //grab row
            $row = $q->fetch();

            //check if row returns
            if ($row['total'] == 1) {
                $this->logger->LogDebug("user found!" . print_r($row, 1));
                return true;
            } else {
                $this->logger->LogDebug("user not found" . print_r($row, 1));
                return false;
            }
        } catch (Exception $e) {
            $this->logger->LogError(print_r($e, 1));
            exit;
        }
    }

    /**
     * Insert new user into database
     * 
     * @var string user first name
     * @var string user last name
     * @var string user email
     * @var string user password
     * @var string user address
     * 
     */
    public function createUser($firstname, $lastname, $email, $password, $address)
    {
        //make connection
        $connection = $this->getConnection();

        //check if address was provided
        if ($address == "") {
            $createUserQuery = "INSERT INTO userdata (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        } else {
            $createUserQuery = "INSERT INTO userdata (firstname, lastname, email, password, address) VALUES (:firstname, :lastname, :email, :password, :address)";
        }

        //prepare statement
        $q = $connection->prepare($createUserQuery);

        //bind params
        $q->bindParam(":firstname", $firstname);
        $q->bindParam(":lastname", $lastname);
        $q->bindParam(":email", $email);
        $q->bindParam(":password", $password);

        //bind address if exists
        if ($address != "") {
            $q->bindParam(":address", $address);
        }

        //execute
        $q->execute();
    }

    /**
     * Check if user list name already exists
     * 
     * @var int user id
     * @var string list name
     * 
     * @return boolean whether list exists
     */
    public function userListExists($userid, $listname)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement
            $q = $connection->prepare("select count(*) as total from userlists where userid = :userid and listname = :listname");
            
            //bind params
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);

            //execute
            $q->execute();

            //fetch row
            $row = $q->fetch();

            //check if row exists
            if ($row['total'] == 1) {
                $this->logger->LogDebug("list found" . print_r($row, 1));
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    /**
     * Create user list
     * 
     * @var int user id
     * @var string list name
     * @var int whether list is public
     * 
     */
    public function createUserList($userid, $listname, $isPublic)
    {
        //make connection
        $connection = $this->getConnection();

        //prepare statement
        $createUserQuery = "INSERT INTO userlists (userid, listname, public) VALUES (:userid, :listname, :public)";
        $q = $connection->prepare($createUserQuery);

        //bind params
        $q->bindParam(":userid", $userid);
        $q->bindParam(":listname", $listname);
        $q->bindParam(":public", $isPublic);

        //execute
        $q->execute();
    }

    /**
     * Get list data from list name and user id
     * 
     * @var int user id
     * @var string list name
     * 
     * @return array rows of list data
     */
    public function getListData($userid, $listname)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement for grabbing list id for easy reference
            $q = $connection->prepare("select listid from userlists where userid = :userid and listname = :listname");

            //bind params
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);

            //execute
            $q->execute();
            $listid = $q->fetch(PDO::FETCH_COLUMN);

            //prepare statement for grabbing list data
            $query = $connection->prepare("select * from userlistdata where userid = :userid and listid = :listid");

            //bind params
            $query->bindParam(":userid", $userid);
            $query->bindParam(":listid", $listid);

            //execute
            $query->execute();

            //fetch and return rows
            $rows = $query->fetchAll();
            return $rows;
            //$this->logger->LogDebug("Found Lists: " . print_r($rows,1));
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    /**
     * Get list id from user id and list name
     * 
     * @var int user id
     * @var string list name
     * 
     * @return int list id
     */
    public function getListId($userid, $listname)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement
            $q = $connection->prepare("select listid from userlists where userid = :userid and listname = :listname");

            //bind params
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);

            //execute
            $q->execute();

            //grab list id and return
            $listid = $q->fetch(PDO::FETCH_COLUMN);
            return $listid;
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    /**
     * Insert list item into database
     */
    public function createListItem($userid, $listname, $name, $link, $price)
    {
        //make connection
        $connection = $this->getConnection();
        try {
            //prepare statement for getting list id
            $q = $connection->prepare("select listid from userlists where userid = :userid and listname = :listname");
            
            //bind params
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);
            
            //execute
            $q->execute();

            //get list id
            $listid = $q->fetch(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }

        //prepare statment for inserting list data
        $createUserQuery = "INSERT INTO userlistdata (userid, listid, name, link, price) VALUES (:userid, :listid, :name, :link, :price)";
        $r = $connection->prepare($createUserQuery);


        //bind params
        $r->bindParam(":userid", $userid);
        $r->bindParam(":listid", $listid);
        $r->bindParam(":name", $name);
        $r->bindParam(":link", $link);
        $r->bindParam(":price", $price);

        //execute
        $r->execute();
    }
}
