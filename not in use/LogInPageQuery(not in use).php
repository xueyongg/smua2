<?php
	session_start();
	$servername = "localhost";
	$connUsername = "root";
	$connPassword = "root";
	
	$conn = new mysqli($servername,$connUsername,$connPassword, 'xyDB');

	if($conn -> connect_error){
		die("Connection failed: ". $conn->connect_error);
	}else{
		echo "Connect Successfully!<br>";
	}


	$mysql = "select fullName, password,lgname from userDB where userName = ?";
	$stmt = $conn->prepare($mysql);
	$stmt->bind_param('s', $username);
	$username = $_POST["requestedUsername"];
	$stmt->execute();
	mysqli_stmt_bind_result($stmt,$fullname,$password,$lg);
	mysqli_stmt_store_result($stmt);

	$error = false;
	if(mysqli_stmt_num_rows($stmt) < 1){
		echo "Invalid User<br>";
		$error = true;
	}
	
	while($row = mysqli_stmt_fetch($stmt)){
		
		if($password !== $_POST["requestedPassword"]){
		echo "incorrect password, please try again!<br>";
		$error = true;
		}
		else{
			Echo "Log in Successfully!<br>";
			Echo "welcome, $fullname<br>";
			$_SESSION['fullname'] = $fullname;
			$_SESSION['username'] = $username;
			$_SESSION['lg'] = $lg;
		}
		
	}

	if($error){
		mysqli_close($conn);
		echo "redirecting...";
		echo "<meta http-equiv='refresh' content='2;url=LogInPage.php'>";
	}else{
		mysqli_close($conn);
		echo "redirecting...";
		echo "<meta http-equiv='refresh' content='2;url=MainPage.php'>";
	}
	
	//will settle the form and the database insertion here!!

	//to clean up the input data, remove the slases and extra spaces
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>