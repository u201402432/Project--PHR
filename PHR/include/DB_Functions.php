<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

// use doctor
header("Content-Type:text/html;charset=utf-8"); 

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $userid, $password, $hospitalname, $hospitaladdress, $hospitalphonenumber, $DRphonenumber, $DRemail) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO doctors(unique_id, userid, name, hospitalname,hospitaladdress,hospitalphonenumber,DRphonenumber,DRemail, encrypted_password, salt)
            VALUES('$uuid', '$userid','$name', '$hospitalname', '$hospitaladdress', '$hospitalphonenumber', '$DRphonenumber', '$DRemail', '$encrypted_password', '$salt')");
        //$stmt->bind_param($uuid, $name, $email, $educationofficer, $studentnumber, $birth, $encrypted_password, $salt, $school_id, $registration_id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE userid = ?");
            $stmt->bind_param("s", $userid);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($userid, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE userid = ?");

        $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    public function getusersalltabledirectresult()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users");

       // $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {
            //$user = $stmt->get_result()->fetch_assoc();
            $user = $stmt->get_result();
            $stmt->close();
            return $users;
        }
        return null;

    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($userid) {
        $stmt = $this->conn->prepare("SELECT userid from doctors WHERE userid = ?");

        $stmt->bind_param("s", $userid);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

}

?>
