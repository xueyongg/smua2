<?php
	function customError($errno, $errstr){
		echo "<b> error: </b> [$errno] $errstr </br>";
	}
	set_error_handler("customError");

	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
	//checking if the file is fake or not
	if(isset($_POST["submit"])){
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		//echo "Image has been upload -" . $check["mime"] . ".<br>";
		$uploadOk = 1;
	}else{
		echo "Upload is unsuccessful!";
		$uploadOk = 0;
	}

	//checking file existence
	if(file_exists($target_file)){
		echo "This file has already been uploaded<br>";
		$uploadOk = 0;
	}

	//checking file size
	if($_FILES["fileToUpload"]["size"] > 5000000){
		echo "File is too big to be uploaded.";
		$uploadOk = 0;
	}

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	if($uploadOk == 0){
		echo "Sorry, the file was not uploaded.";
		echo "<meta http-equiv='refresh' content='2;url=MainPage.php'>";
	} else{
		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
			echo "File ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded";
			echo "<meta http-equiv='refresh' content='2;url=MainPage.php'>";
		}else{
			echo "Sorry, upload error.";
		}
	}

?>