<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
header("Content-Type:application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');


// json response array
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'igrus');
define('DB_PASSWORD', 'Dkdlrmfntm123');
define('DB_DATABASE', 'igrus');
$connection = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);


$return_arr = Array();


//echo $query;
$result = mysqli_query($connection,"SELECT * FROM users"); 

while ($row = mysqli_fetch_array($result)) {
    $row_array['userid'] = $row['userid'];
    $row_array['name'] = $row['name'];
    $row_array['birth'] = $row['birth'];
       $row_array['sex'] = $row['sex'];
          $row_array['phonenumber'] = $row['phonenumber'];



    array_push($return_arr,$row_array);
}

echo json_encode($return_arr,JSON_UNESCAPED_UNICODE); 
?>

