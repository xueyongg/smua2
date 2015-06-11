<?php
	session_start();
?>
<!DOCTYPE>
<html>
	<head>
		Welcome, <?php echo $_SESSION['fullname']; ?>.<br>
	</head>
	<body>
		<form method = "post" Action = "upload.php" enctype="multipart/form-data">
		<input type = "file" name = "fileToUpload" id = "fileToUpload"><br>
		<input type = "submit" value = "upload" name = "submit">
		<button onclick = "history.go(-1)">Back</button>
	</body>
</html>