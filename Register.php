<?php
	session_start();
?>
<html>
<style>
	body{
		
		text-align: center;
	}
	h1{
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
	.error {color: #FF0000;}
</style>

	<head>
		<link link = "stylesheet" type = "text/css" href = "Style.css">
		<title>
			Registration page
		</title>
	</head>
	<Body>
		<h1>
			Registration Form
		</h1>

		<?php
			$nameErr = $fullnameErr = $commentErr = $passwordErr = "";
		?>
		
		<form method = "post" action = "registerQuery.php">

			username: <input type = "text" required autocomplete = "off" name = "username" placeholder = "required"><br>
				<!--<span class = "error">*<?php echo $nameErr?></span></br>-->
			Full name: <input type = "text" required autocomplete = "off" name = "fullname" placeholder = "required"><br>
				<!--<span class = "error">*<?php echo $fullnameErr?></span></br>-->
			Password: <input type = "password" name = "password" required autocomplete = "off" placeholder = "required"><br>
				<!--<span class = "error">*<?php echo $passwordErr?></span></br>-->
			Confirm password: <input type = "password" name = "confirmPassword" required autocomplete = "off"></br>
			Lg: 
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
				echo "<select name = 'lg' required autocomplete = 'off'>";
				echo '<option value = "" selected>--Lg Name--</option>';
				
				$mysql = "select * from listoflg";
				$stmt = $conn->prepare($mysql);
				$stmt->execute();
				mysqli_stmt_bind_result($stmt,$lg);
				while(mysqli_stmt_fetch($stmt)){
					echo "<option value = $lg >$lg</option>";
					
				}
				echo "</select><br>";
				
			?>
			birthday: <input type="date" name = "birthday" required autocomplete = "off"><br>
			Facebook: <input type = "text" name = "facebook" placeholder = "Facebook link"><br>
			Blog: <input type = "text" autocomplete = "off" name = "blog"  placeholder = "Blog link"><br>
			Instagram: <input type = "text" name = "instagram" placeholder = "Instagram link"><br>
			contact No: <input type = "text" name = "contactNumber" placeholder = "eg. 91234567"><br>
			NRIC: <input type = "text" name = "NRIC" required autocomplete = "off" placeholder = "eg. S1234567A"><br>
			Shirt Size: <input type = "text" name = "shirtSize" required autocomplete = "off" placeholder = "Shirt size"><br>

			<input type = "submit" name = "submit>"></br>

		</form>
		<button onclick='history.go(-1)'>back</button> <br>
		
	</Body>
	
</html>