<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
header("Content-Type:text/html;charset=utf-8"); 
header("Content-Type:application/json;charset=utf-8"); 

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['name']) && isset($_POST['userid']) && isset($_POST['hospitalname'])&&  isset($_POST['hospitaladdress']) &&  isset($_POST['hospitalphonenumber']) && isset($_POST['password']) && isset($_POST['DRphonenumber']) && isset($_POST['DRemail'])  ) {

    // receiving the post params
    $name = $_POST['name'];
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $hospitalname = $_POST['hospitalname'];
    $hospitaladdress = $_POST['hospitaladdress'];
    $hospitalphonenumber = $_POST['hospitalphonenumber'];

    $DRphonenumber = $_POST['DRphonenumber'];
    $DRemail = $_POST['DRemail'];



    // check if user is already existed with the same email
    if ($db->isUserExisted($userid)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $userid;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($name, $userid, $password, $hospitalname, $hospitaladdress, $hospitalphonenumber, $DRphonenumber, $DRemail);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["name"] = $user["name"];
            $response["userid"] = $user["userid"];
            echo json_encode($response);
            echo "<script> document.location.href='list.html'; </script>";

        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, userid, password, hospitalname, hospitaladdress, hospitalphonenumber, DRphonenumber, DRemail) is missing!";
    echo json_encode($response);
}
?>

