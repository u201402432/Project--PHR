<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
//header("Content-Type:application/json; charset=utf-8");
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
if (isset($_POST['userid']))
{

//echo $query;
	$result = mysqli_query($connection,"SELECT * FROM users WHERE userid = '".$_POST['userid']."' "); 

	while ($row = mysqli_fetch_array($result)) {
		$row_array['userid'] = $row['userid'];
		$row_array['name'] = $row['name'];
		$row_array['birth'] = $row['birth'];
		$row_array['sex'] = $row['sex'];
		$row_array['phonenumber'] = $row['phonenumber'];
		$row_array['st_place'] = $row['st_place'];
		$row_array['st_main'] = $row['st_main'];
		$row_array['st_scale'] = $row['st_scale'];
		$row_array['st_sub'] = $row['st_sub'];


		array_push($return_arr,$row_array);
	}

	//echo json_encode($row_array,JSON_UNESCAPED_UNICODE); 
}
else
{
	echo "userid not post error";
}
?>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">	<title>SignUp Form</title>
	<link rel="stylesheet" href="signup.css">

</head>
<body>
	<div class="main-content">

		<!-- You only need this form and the form-register.css -->

		<form class="form-register" method="post" action="doctorRegister.php">

			<div class="form-register-with-email">

				<div class="form-white-background">

					<div class="form-title-row">
						<h1>Information an Patient</h1>
					</div>
					<div class="form-row">
						<label>
							<span>ID</span>
							<?php echo $row_array['userid']; ?>
						</label>
					</div>

					<div class="form-row">
						<label>
							<span>Name</span>
							<?php echo $row_array['name']; ?>
						</label>
					</div>

					<div class="form-row">
						<label>
							<span>Birth</span>
							<?php echo $row_array['birth']; ?>
						</label>
					</div>

					<div class="form-row">
						<label>
							<span>Height</span>
							184.2 cm
						</label>
					</div>
					<div class="form-row">
						<label>
							<span>Weight</span>
							82.6 kg
						</label>
					</div>
					<div class="form-row">
						<label>
							<span>Sex</span>
							<?php 
							if(strcmp($row_array['birth'],"1")) 
								echo "남자";
							else
								echo "여자";
							?>
						</label>
					</div>
					<div class="form-row">
						<label>
							<span>Phone</span>
							<?php echo $row_array['phonenumber']; ?>
						</label>
					</div>
					<hr>
					<div class="form-row">
						<label>
							<span>Symptom</span>
							<?php echo $row_array['st_place']."-".$row_array['st_main']." (NRS : ".$row_array['st_scale'].")"; ?>
						</label>
					</div>

					<div class="form-row">
						<label>
							<span>SymptomETC</span>
							<?php echo $row_array['st_sub']; ?>
						</label>
					</div>
					<hr>
					<div class="form-row">
						<label>
							<span>Comment</span>
							업무가 많아지며 두통이 심해졌습니다.
						</label>
					</div>	

					<button>EMR로 보내기</button>
				</div>


			</div>

			<div class="form-sign-in-with-social">



			</div>

		</form>

	</div>
</body>
</html>