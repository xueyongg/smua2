<?php
	session_start();
	function customError($errNo, $errStr){
		echo "<b> error: </b> [$errNo] $errStr";
	}
	set_error_handler("customError");
?>
<html>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "/smua2/css/Style.css">
		<title>
			Log in
		</title>

	</head>
	<body>
		<?php
			echo "<h1>";
				$d1 = strtotime("16 June ");
				$d2 = ceil(($d1-time())/60/60/24);
				echo "You are left with ".$d2. " days till your deadline!";
			echo "</h1>";

			$nameErr = $emailErr = $genderErr = $websiteErr = "";
			$name = $email = $gender = $website = "";

			$time = date("H");
			date_default_timezone_set("Singapore");
			echo "Today is ".date("d-m-y"). "<br>";
			echo "The time is ". date("h.i.sa"). "</br>";
		?>
		<div class = "logIn">

			<h3>Log In Page</h3>
			<form method = 'post' Action = "<?php echo $_SERVER['PHP_SELF']?>">
			Username: <Input type = "text" require autocomplete = "off" name = "requestedUsername"></br>
			password: <Input type = "password" require autocomplete = "off" name = "requestedPassword"></br>
			<input type = "submit" name = "Login" value = "Log in"></input>
			<h5>
				<A href = "http://localhost:8888/Self/Register.php">Register?</A>
			</h5>

			</form>
		<?php

			$servername = "localhost";
			$connUsername = "root";
			$connPassword = "root";
			
			$conn = new mysqli($servername,$connUsername,$connPassword, 'xyDB');

			/*if($conn -> connect_error){
				die("Connection failed: ". $conn->connect_error);
			}else{
				echo "Connect Successfully!<br>";
			}*/

			if(isset($_POST['requestedUsername'])){
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
					}else{
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
					echo "<meta http-equiv='refresh' content='2;url=login.php'>";
				}else{
					mysqli_close($conn);
					echo "<meta http-equiv='refresh' content='1;url=/smua2/pages/MainPage.php'>";
				}
				
				//will settle the form and the database insertion here!!

				//to clean up the input data, remove the slases and extra spaces
				function test_input($data){
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}
			}
			?>
		</div>


	</body>
	<footer>
		© <?php echo date("Y")." Xueyong"?>
	</footer>
	<style>
	h3{
			font-family: times, Times New Roman, times-roman, georgia, serif;
			color: #444;
			margin: 0;
			padding: 0px 0px 6px 0px;
			font-size: 51px;
			line-height: 44px;
			letter-spacing: -2px;
			font-weight: bold;
			text-align: center;

		}
	</style>
	
</html>