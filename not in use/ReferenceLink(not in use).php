<?php
	
	$servername = "localhost";
	$connUsername = "root";
	$connPassword = "root";
	$conn = new mysqli($servername,$connUsername,$connPassword, 'xyDB');

	/*
	if($conn -> connect_error){
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
	<head>
		<?php if(strcmp($username,"Admin") == 0) echo "<meta http-equiv='refresh' content='0;url=AdminReferenceLink.php'>";?>
		<ul>
			<li class = "tab1"><A target = "_blank" href = <?php echo $_SESSION['blog']?>>Blog</A></li>
			<li class = "tab2"><A target = "_blank" href = <?php echo $_SESSION['facebook']?>>Facebook</A></li>
			<li class = "tab3"><A target = "_blank" href = <?php if(isset($_SESSION['instagram']))echo $_SESSION['instagram'];else echo""?>>Instagram</A></li>
			<li class = "tab4"><A href = "">Biography</A></li>
			<li class = "tab5"><A href = 'lg.php'><?php echo strtoupper($_SESSION['lg']);?></A></li>
			<li class = "tab6"><A href = "uploadFunction.php">Upload a file</A></li>
			<li class = "tab7"><A href = 'http://localhost:8888/Self/Setting.php'>Setting</A></li>
			<li class = "logout"><A href = "logout.php">Logout</A></li><br>
		</ul>
	</head>
	<style>
		head{
			text-align:center;
		}
		ul{
			list-style-type:none;
		}
		li{
			display:inline;
		}
	</style>
</html>
