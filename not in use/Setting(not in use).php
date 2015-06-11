<?php
	session_start();
?>
<html>
	<head>
		<link rel = "stylesheet " text = "style/css" href ="Style.css">
		Hi, <?php echo $_SESSION["fullname"]; ?>. Welcome to the setting's page!
	</head>

	<body>
		<form method ="post" Action = "SettingQuery.php">
			<!--Username: <input type = "text" name = "updatedUsername" value = <?php if(isset($_SESSION['username']))echo $_SESSION['username']; else echo "placeholder = 'Username'";?>><br>-->
			Fullname: <input type = "text" name = "updatedFullname" value = <?php if(isset($_SESSION['fullname']))echo $_SESSION['fullname']; else echo "placeholder = 'Fullname'";?>><br>
			Facebook: <input type = "text" name = "updatedFacebook" value = "<?php if(isset($_SESSION['facebook']))echo $_SESSION['facebook'];?>" placeholder = "Facebook link"><br>
			Blog: <input type = "text" name = "updatedBlog" value = "<?php if(isset($_SESSION['blog']))echo $_SESSION['blog'];?>" placeholder = "Blog link"><br>
			Instagram: <input type = "text" name = "updateInstagram" value = "<?php if(isset($_SESSION['instagram']))echo $_SESSION['instagram'];?>" placeholder = "Instagram link"><br>
			birthday: <input type="date" name = "birthday" value = "<?php if(isset($_SESSION['birthday']))echo $_SESSION['birthday'];?>"><br>
			contact No: <input type = "text" name = "updateContactNumber" value = "<?php if(isset($_SESSION['contactNumber']))echo $_SESSION['contactNumber'];?>" placeholder = "91234567"><br>
			NRIC: <input type = "text" name = "updateNRIC" value = "<?php if(isset($_SESSION['nric']))echo $_SESSION['nric'];?>" placeholder = "S1234567A"><br>
			Shirt Size: <input type = "text" name = "updateShirtSize" value = "<?php if(isset($_SESSION['size']))echo $_SESSION['size'];?>" placeholder = "Shirt size"><br>
			Address: <input type = "text" name = "updateAddress" value = "<?php if(isset($_SESSION['address']))echo $_SESSION['address'];?>" placeholder = "Address"><br>

			<input type = "submit" value = "Save">
			<button onclick = "history.go(-1);">Back</button>
		</form>
	</body>
</html>

