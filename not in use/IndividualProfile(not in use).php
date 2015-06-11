<?php Session_start();?>
<html>
	<head>
		<link rel="stylesheet" type="style/css" href="Style.css">
		<h1>About Us</h1></br>
		<div class = "menu">
			<?php include "GroupReferenceLink.php" ?><br>
		</div>
	</head>
	<body>
		<form method = "POST" ACTION = "<?php echo $_SERVER['PHP_SELF']?>">
		<?php
			$servername = "localhost";
			$connUsername = "root";
			$connPassword = "root";
			$conn = new mysqli($servername,$connUsername,$connPassword, 'xyDB');

			/*if($conn -> connect_error){
				die("Connection failed: ". $conn->connect_error);
			}else{
				echo "Connect Successfully.<br>";
			}*/
			$mysqli = "select username from userdb where lgname = ?";
			$stmt = $conn->prepare($mysqli);
			$stmt->bind_param('s',$lg);
			$lg = $_SESSION['lg'];
			$stmt->execute();
			mysqli_stmt_bind_result($stmt,$user);

			echo "Name: <select name = 'selectedName'>";
			echo "<option value='' selected>---members---</option>";
			while(mysqli_stmt_fetch($stmt)){
				echo "<option value = $user>$user</option>";
			}
			echo "</select>";
			echo "<input type = 'submit'></input>";

		?>
		</form>
		<a href = "register.php">Member not found?</a>

		<?php
			$mysqli = "select * from userdb where username = ? and lgname = ?";
			$stmt = $conn->prepare($mysqli);
			$stmt->bind_param('ss',$user, $lg);
			$lg = $_SESSION['lg'];
			if(isset($_POST['selectedName'])){
				$user = $_POST['selectedName'];
				$stmt->execute();
				mysqli_stmt_bind_result($stmt,$user,$pass,$fullname,$birthday,$contact,$add,$nric,$shirtsize,$lgname);
				echo "<table>";
				while(mysqli_stmt_fetch($stmt)){
					echo "<tr><td>fullname: </td><td>".$fullname."</td></tr><br>";
					echo "<tr><td>Birthday: </td><td>".$birthday."</td></tr><br>";
					echo "<tr><td>Contact Number: </td><td>".$contact."</td></tr><br>";
					echo "<tr><td>Address: </td><td>".$add."</td></tr><br>";
					echo "<tr><td>NRIC: </td><td>".$nric."</td></tr><br>";
					echo "<tr><td>Shirt Size: </td><td>".$shirtsize."</td></tr><br>";

				}
			}
		?>
	</body>
	<style>
		{
			float:center;
			margin-top:90px;
		}
	</style>

</html>
