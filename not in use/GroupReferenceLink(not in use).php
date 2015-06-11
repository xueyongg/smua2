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
	$stmt = $conn->prepare("select blog, facebook, instagram from reference_table r where username = ?");
	$stmt->bind_param("s",$username);
	$username = $_SESSION['username'];
	$stmt->execute();
	mysqli_stmt_bind_result($stmt, $blog, $facebook, $instagram);
	while(mysqli_stmt_fetch($stmt)){
		$_SESSION['blog'] = $blog;
		$_SESSION['facebook'] = $facebook;
		$_SESSION['instagram'] = $instagram;
	}
?>
<html>
	<body>
	<ul>
	<li class = "tab active"><A href = "AboutUs.php">About us</A></li>
	<li><A href = "IndividualProfile.php">Individual profile</A></li> <!--This will have drop down option of the people in the the group -->
	<li><A href = "https://www.facebook.com/groups/194097773966901/">SMU facebook page</A></li> <!--This will direct user to facebook page -->
	<li><A href = "">Photo Gallery</A></li>
	<li><A href = "">timetable</A></li>
	<li><A href = "">Finance</A></li>
	<li><A href = "Register.php">Add members</A></li> <!--This will bring them to the registration page, with preset lgname: whichever the link was clicked from-->
	<li><A href = "logout.php">Logout</A></li> <!--This will end the sessions and bring them back to log in page -->
	</ul><br>
	</body>
	<style>
		ul{
			list-style-type:none;
			margin:0;
			padding:0;
			
		}
		li{
			float:left;
			margin:20px;

		}
		
		a{
			display:block;

		}
		
		#colorNav > ul{
		    width: 450px;
		    margin:0 auto;
		}
		#colorNav > ul > li{ /* will style only the top level li */
		list-style: none;
		box-shadow: 0 0 10px rgba(100, 100, 100, 0.2) inset,1px 1px 1px #CCC;
		display: inline-block;
		line-height: 1;
		margin: 1px;
		border-radius: 3px;
		position:relative;
		}
	</style>
</html>
