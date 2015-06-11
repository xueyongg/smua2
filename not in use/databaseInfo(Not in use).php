<?php
	session_start();
?>
<html>
	<head>
	<link rel="stylesheet" type = "text/css" href="Style.css">
		<h1>Welcome to the overview of the website.</h1><br>
		This is the list of people registered in the database:<br>
	</head>

	<body>
		
		<?php
			$servername = "localhost";
			$connUsername = "root";
			$connPassword = "root";
			$conn = new mysqli($servername,$connUsername,$connPassword, 'xyDB');

			/*($conn -> connect_error){
				die("Connection failed: ". $conn->connect_error);
			}else{
				echo "Connect Successfully.<br>";
			}*/
			$stmt = $conn->prepare("select u.username,fullname,birthday,contactno,nric,shirtsize,blog
									from reference_table r, userdb u where u.username = r.username;");
			$stmt->execute();
			mysqli_stmt_bind_result($stmt,$user,$full,$birth,$contact,$nric,$shirtsize,$blog);
			echo"<table>";
			echo"<tr><th>no</th><th>Username</th><th>Fullname</th><th>birthday</th><th>Contact Number</th><th>NRIC</th><th>Shirt Size</th><th>Blog Link</th></tr>";
			$count = 1;
			while(mysqli_stmt_fetch($stmt)){
				
				echo "<tr><td>".$count."</td><td>".$user."</td><td>".$full."</td><td>".$birth."</td><td>"
					.$contact."</td><td>".$nric."</td><td>".$shirtsize."</td><td>".$blog."</td></tr><br>";

				$count++;
			}
			echo"</table>";
		?>
		<button onclick="history.go(-1)">Back</button>
	</body>
	<style>
		
		
	</style>
</html>