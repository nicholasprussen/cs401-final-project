<?php

require_once 'KLogger.php';

class Dao {

    public $host = 'localhost';
    public $user = 'root';
    public $password = '';
    protected $logger;

    public function __construct() {
        $this->logger = new KLogger ( "log.txt" , KLogger::DEBUG );
    }
    
    private function getConnection() {
        try {
            $connection = new PDO('mysql:host='.$this->host.';dbname=mygiftlists', $this->user, $this->password);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->logger->LogDebug("Got a connection");
        } catch (PDOException $e) {
            $error = 'Connection failed ' . $e->getMessage();
            $this->logger->LogError($error);
        }
        return $connection;
    } 

    public function userExists($email, $password) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select count(*) as total from userdata where email = :email and password = :password");
            $q->bindParam(":email", $email);
            $q->bindParam(":password", $password);
            $q->execute();
            $row = $q->fetch();
            if ($row['total'] == 1){
                $this->logger->LogDebug("user found!" . print_r($row,1));
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    public function userIdentification($email, $password) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select * from userdata where email = :email and password = :password");
            $q->bindParam(":email", $email);
            $q->bindParam(":password", $password);
            $q->execute();
            $row = $q->fetch();
            $this->logger->LogDebug("Found user id " . print_r($row, 1));
            return $row['userid'];
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    public function getUserInfo($userid) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select * from userdata where userid = :userid");
            $q->bindParam(":userid", $userid);
            $q->execute();
            $row = $q->fetch();
            $retArray = [
                "firstname" => $row['firstname'],
                "lastname" => $row['lastname'],
                "email" => $row['email']
            ];
            return $retArray;
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    public function getUserLists($userid) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select listname from userlists where userid = :userid");
            $q->bindParam(":userid", $userid);
            $q->execute();
            $rows = $q->fetchAll(PDO::FETCH_COLUMN);
            //$this->logger->LogDebug("Found Lists: " . print_r($rows,1));
            return $rows;
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    public function emailExists($email) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select count(*) as total from userdata where email = :email");
            $q->bindParam(":email", $email);
            $q->execute();
            $row = $q->fetch();
            if ($row['total'] == 1){
                $this->logger->LogDebug("user found!" . print_r($row,1));
                return true;
            } else {
                $this->logger->LogDebug("user not found" . print_r($row,1));
                return false;
            }
        } catch (Exception $e) {
            $this->logger->LogError(print_r($e, 1));
            exit;
        }
    }

    public function createUser($firstname, $lastname, $email, $password) {
        $this->logger->LogDebug("inserting user with ".$firstname." ".$lastname." ".$email." ".$password." ");
        $connection = $this->getConnection();
        $createUserQuery = "INSERT INTO userdata (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $q = $connection->prepare($createUserQuery);
        $q->bindParam(":firstname", $firstname);
        $q->bindParam(":lastname", $lastname);
        $q->bindParam(":email", $email);
        $q->bindParam(":password", $password);
        $q->execute();
    }

    public function userListExists($userid, $listname) {
        $this->logger->LogDebug("checking for lists with ".$userid." ".$listname);
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select count(*) as total from userlists where userid = :userid and listname = :listname");
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);
            $q->execute();
            $row = $q->fetch();
            if ($row['total'] == 1){
                $this->logger->LogDebug("list found" . print_r($row,1));
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    public function createUserList($userid, $listname, $isPublic) {
        $this->logger->LogDebug("inserting user with ".$userid." ".$listname." ".$isPublic);
        $connection = $this->getConnection();
        $createUserQuery = "INSERT INTO userlists (userid, listname, public) VALUES (:userid, :listname, :public)";
        $q = $connection->prepare($createUserQuery);
        $this->logger->LogDebug(print_r($q, 1));
        $q->bindParam(":userid", $userid);
        $q->bindParam(":listname", $listname);
        $q->bindParam(":public", $isPublic);
        $q->execute();
    }

    public function getListData($userid, $listname) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select listid from userlists where userid = :userid and listname = :listname");
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);
            $q->execute();
            $listid = $q->fetch(PDO::FETCH_COLUMN);
            $this->logger->LogDebug($listid);
            $query = $connection->prepare("select * from userlistdata where userid = :userid and listid = :listid");
            $query->bindParam(":userid", $userid);
            $query->bindParam(":listid", $listid);
            $query->execute();
            $rows = $query->fetchAll();
            return $rows;
            //$this->logger->LogDebug("Found Lists: " . print_r($rows,1));
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    public function getListId($userid, $listname) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select listid from userlists where userid = :userid and listname = :listname");
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);
            $q->execute();
            $listid = $q->fetch(PDO::FETCH_COLUMN);
            return $listid;
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
    }

    public function createListItem($userid, $listname, $name, $link, $price) {
        $connection = $this->getConnection();
        try {
            $q = $connection->prepare("select listid from userlists where userid = :userid and listname = :listname");
            $q->bindParam(":userid", $userid);
            $q->bindParam(":listname", $listname);
            $q->execute();
            $listid = $q->fetch(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }

        $this->logger->LogDebug("Adding item with " . $userid . " " . $listid . " " . $name . " " . $link . " " . $price);

        // if ($link == "null") {
        //     $createUserQuery = "INSERT INTO userlistdata (userid, listid, name, price) VALUES (:userid, :listid, :name, :price)";
        // } else {
        //     $createUserQuery = "INSERT INTO userlistdata (userid, listid, name, link, price) VALUES (:userid, :listid, :name, :link, :price)";
        //     $q->bindParam(":link", $link);
        // }
        $createUserQuery = "INSERT INTO userlistdata (userid, listid, name, link, price) VALUES (:userid, :listid, :name, :link, :price)";
        $r = $connection->prepare($createUserQuery);
        $this->logger->LogDebug(print_r($q, 1));
        $r->bindParam(":userid", $userid);
        $r->bindParam(":listid", $listid);
        $r->bindParam(":name", $name);
        $r->bindParam(":link", $link);
        $r->bindParam(":price", $price);
        $r->execute();
        $this->logger->LogDebug(print_r($r->debugDumpParams(), 1));
        
    }
}
