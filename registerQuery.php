<?php
	session_start();	
	$servername = "localhost";
	$connUsername = "root";
	$connPassword = "root";
	$conn = new mysqli($servername,$connUsername,$connPassword, 'xyDB');

	if($conn -> connect_error){
		die("Connection failed: ". $conn->connect_error);
	}else{
		echo "Connect Successfully.<br>";
	}
	if(isset($_POST["username"]))
	if(strlen($_POST["username"]) > 0 && strlen($_POST["fullname"]) > 0 && strlen($_POST["password"]) > 2){
		if(isAvailable($_POST["username"])){
			$stmt = $conn->prepare("insert into userDB(username,password,fullname,contactno,address,NRIC,shirtsize,lgname)values(?,?,?,?,?,?,?,?)");
			$stmt->bind_param("ssssssis",$username, $password, $fullname,$contactNumber,$add,$nric,$shirt,$lg);
			//this is to set all the parameters with the appropriate values first
			$username = test_input($_POST["username"]);
			$password = test_input($_POST["password"]);
			$fullname = test_input($_POST["fullname"]);
			$contactNumber = test_input($_POST["contactNumber"]);
			$nric = test_input($_POST["NRIC"]);
			$shirt = test_input($_POST["shirtSize"]);
			$lg = test_input($_POST["lg"]);
			$facebook = test_input($_POST["facebook"]);
			$blog = test_input($_POST["blog"]);
			$instagram = test_input($_POST["instagram"]);

			$stmt->execute();

			$stmt = $conn->prepare("insert into reference_table(username,facebook,blog,instagram)values(?,?,?,?)");
			$stmt->bind_param("ssss",$username,$facebok,$blog,$instagram);
			$stmt->execute();

			echo "User ".$fullname." is successfully created!<br>";
			echo "Redicting...<br>";
			$stmt->close();
			mysqli_close($conn);
			if(isset($_SESSION['username'])){
				echo "<meta http-equiv='refresh' content='3;URL=lg.php'/>";
			}else{
				echo "<meta http-equiv='refresh' content='3;URL=LogInPage.php'/>";
			}
			
		}else{
			echo "username: ". $_POST["username"]." has already been taken<br>";
			mysqli_close($conn);
			echo "<meta http-equiv='refresh' content='3;URL=register.php'/>";
		}
	}else{
		echo "You did not fill in the required fields";
		echo "<meta http-equiv='refresh' content= '3;URL=register.php'/>";
	}

	//to clean up the input data, remove the slases and extra spaces
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function isAvailable($requestedUserName){
		global $conn;
		$checkstmt = $conn->prepare("select fullname from userdb where username = ?");
		$checkstmt->bind_param("s",$username);
		$username = test_input($_POST["username"]);
		$checkstmt->execute();
		mysqli_stmt_bind_result($checkstmt,$fullname);
		mysqli_stmt_store_result($checkstmt);
		if(mysqli_stmt_num_rows($checkstmt) <1){
			echo "Available!<br>";
			return true;
			$checkstmt->close();
		}
		return false;

	}
?>