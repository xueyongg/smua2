<?php
	session_start();
	//write the open connection
	//associate it to the reference_table
	$servername = "localhost";
	$connUsername = "root";
	$connPassword = "root";
	
	$conn = new mysqli($servername,$connUsername,$connPassword, 'xyDB');

	if($conn -> connect_error){
		die("Connection failed: ". $conn->connect_error);
	}else{
		echo "Connect Successfully!<br>";
	}

	$updatedFullname = $updatedBlog = $updatedFacebook = $updateContactNumber = $updateNRIC = $updateShirtSize = $mysql = "";
	$username = $_SESSION['username'];
	if(isset($_POST['updatedFullname'])){
		$updatedFullname = $_POST['updatedFullname'];
		$_SESSION['fullname'] = $updatedFullname;
	}else{
		if(isset($_SESSION['fullname']))
			$updatedFullname = $_SESSION['fullname'];
	}
	if(isset($_POST['updatedBlog'])){
		$updatedBlog = $_POST['updatedBlog'];
		$_SESSION['blog'] = $updatedBlog;
	}else{
		if(isset($_SESSION['blog']))
			$updatedBlog = $_SESSION['blog'];
	}
	if(isset($_POST['updatedFacebook'])){
		$updatedFacebook = $_POST['updatedFacebook'];
		$_SESSION['facebook'] = $updatedFacebook;
	}else{
		if(isset($_SESSION['facebook']))
			$updatedFacebook = $_SESSION['facebook'];
	}
	if(isset($_POST['updatedInstagram'])){
		$updatedInstagram = $_POST['updatedInstagram'];
		$_SESSION['instagram'] = $updatedInstagram;
	}else{
		if(isset($_SESSION['instagram'])){
			$updatedInstagram = $_SESSION['instagram'];
		}
	}
	if(isset($_POST['updateContactNumber'])){
		$updateContactNumber = $_POST['updateContactNumber'];
		$_SESSION['contactNumber'] = $updateContactNumber;
	}else{
		if(isset($_SESSION['contactNumber'])){
			$updateContactNumber = $_SESSION['updateContactNumber'];
		}
	}
	if(isset($_POST['updateNRIC'])){
		$updateNRIC = $_POST['updateNRIC'];
		$_SESSION['nric'] = $updateNRIC;
	}else{
		if(isset($_SESSION['nric'])){
			$updateNRIC = $_SESSION['updateNRIC'];
		}
	}
	if(isset($_POST['updateShirtSize'])){
		$updateShirtSize = (int)$_POST['updateShirtSize'];
		$_SESSION['size'] = $updateShirtSize;
	}else{
		if(isset($_SESSION['size'])){
			$updateShirtSize = $_SESSION['size'];
		}
	}


	$mysql = "update reference_table set facebook = ?, blog = ?, Instagram = ? where username = ? ";
	$stmt= $conn->prepare($mysql);
	$stmt->bind_param('ssss',$updatedFacebook, $updatedBlog,$updatedInstagram, $username);
	$stmt->execute();
	mysqli_stmt_store_result($stmt);
	$mysql = "update userdb set contactNo = ?, NRIC = ?, shirtSize = ? where username = ? ";
	$secstmt= $conn->prepare($mysql);
	$secstmt->bind_param('ssis',$updateContactNumber, $updateNRIC,$updateShirtSize, $username);
	$secstmt->execute();
	mysqli_stmt_store_result($secstmt);
	if(mysqli_stmt_affected_rows($secstmt) > 0 ){
		echo "Edits saved.<br>";
		echo "redirecting...";
		echo "<meta http-equiv = 'refresh' content = '2;url= MainPage.php'>";
	}else{
		echo "error!";
	}
	
?>