<?php
	session_start();

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
	$stmt = $conn->prepare("select u.username,fullname,birthday,contactno,nric,shirtsize,address
									from reference_table r, userdb u where u.username = r.username and u.username = ?;");
	$stmt->bind_param("s",$username);
	$username = $_SESSION['username'];
	$stmt->execute();
	mysqli_stmt_bind_result($stmt,$user,$full,$birth,$contact,$nric,$shirtsize,$add);
	while(mysqli_stmt_fetch($stmt)){
		$_SESSION['birthday'] = $birth;
		$_SESSION['ContactNumber'] = $contact;
		$_SESSION['nric'] = $nric;
		$_SESSION['size'] = $shirtsize;
		$_SESSION['address'] = $add;

	}

?>
<html>
	<head>
		<title>Admin Page</title>
		<link rel = "stylesheet" type = "text/css" href = "/smua2/css/Style.css">
		<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				$("div").hide();
				$(".menu").show();
				$(".link").show();

				$(".tab0").click(function(){
					$("div").hide();
					$(".menu").show();
					$(".link").show();
					$(".welcomemessage").fadeIn();
				});

				$(".tab4").click(function(){
					$("div").hide();
					$(".welcomemessage").hide();
					$(".menu").show();
					$(".link").show();
					$("#abouteveryone").fadeIn();
				});
				$(".tab6").click(function(){
					$("div").hide();
					$("p").hide();
					$(".menu").show();
					$(".link").show();
					$("#dataInfo").fadeIn();
					$(".briefDescription").fadeIn();
				});
				$(".tab7").click(function(){
					$("div").hide();
					$("p").hide();
					$(".menu").show();
					$(".link").show();
					$("#setting").fadeIn();
				});
				$("#settingsaved").click(function(){
					location.reload();
				});
				$(".overview").mouseenter(function(){
					 $("td").css("background-color", "#f0f0f0");
				});
				$("td").mouseleave(function(){
					 $("td").css("background-color", "");
				});
			})
		</script>
		<p class = "welcomemessage">Welecome, <?php echo $_SESSION['fullname']; ?>. This is the administrative page.<br></p>
		<div class = "menu">
			
			<ul>
				<li class = "blogname"><?php echo strtoupper($_SESSION['username']);?></li>
				<div class = "link">
					<li class = "tab1"><A target = "_blank" href = <?php echo $_SESSION['blog']?>>Blog</A></t></li>
					<li class = "tab2"><A target = "_blank" href = <?php echo $_SESSION['facebook']?>>Facebook</A></li>
					<li class = "tab3"><A target = "_blank" href = <?php if(isset($_SESSION['instagram']))echo $_SESSION['instagram'];else echo""?>>Instagram</A></li> 
					<li class = "tab4"><A href = "#abouteveryone">Biography</A></li>
					<li class = "tab5"><A href = 'lg.php'><?php echo strtoupper($_SESSION['lg']);?></A></li>
					<li class = "tab6"><A href = "#dataInfo"> Database information</A></li>
					<li class = "tab7"><A href = '#setting'>Setting</A></li> 
					<li class = "logout"><A href = "logout.php">Logout</A></li><br>
				</div>	
			</ul>
		</div>
	</head>
	<body>
		<div id = "abouteveryone">
			<?php
				$stmt = $conn->prepare("select fullname, description from userdb");
				
				$stmt->execute();
				mysqli_stmt_bind_result($stmt, $fullname, $description);
				echo "<table class = 'displayresults'>";
				echo "<tr><th>no.</th><th>Full name</th><th>Description</th></tr>";
				$count = 1;
				while(mysqli_stmt_fetch($stmt)){
					echo "<tr><td>".$count.".</td><td>".$fullname."</td><td>".$description."</td></tr>";
					$count ++;
				}

				echo"</table>";
			?>
		</div>
		<div id = "dataInfo">
			<p class = "briefDescription">
			This is the list of people registered in the database:
			</p>
			<?php
				$stmt = $conn->prepare("select u.username,fullname,birthday,contactno,nric,shirtsize,blog
										from reference_table r, userdb u where u.username = r.username;");
				$stmt->execute();
				mysqli_stmt_bind_result($stmt,$user,$full,$birth,$contact,$nric,$shirtsize,$blog);
				echo"<table class = 'overview'>";
				echo"<tr><th>no</th><th>Username</th><th>Fullname</th><th>birthday</th><th>Contact Number</th><th>NRIC</th><th>Shirt Size</th><th>Blog Link</th></tr>";
				$count = 1;
				while(mysqli_stmt_fetch($stmt)){
					if($user !== "Admin"){
						echo "<tr><td>".$count."</td><td>".$user."</td><td>".$full."</td><td>".$birth."</td><td>"
						.$contact."</td><td>".$nric."</td><td>".$shirtsize."</td><td><a target = '_blank' class = 'blogLink' href = ".$blog.">".$blog."</a></td></tr><br>";

						$count++;
					}
					
				}
				echo"</table>";
			?>
		</div>

		<div id ="setting">
			<form method ="post" Action = "<?php echo $_SERVER['PHP_SELF']?>">
				<!--Username: <input type = "text" name = "updatedUsername" value = <?php if(isset($_SESSION['username']))echo $_SESSION['username']; else echo "placeholder = 'Username'";?>><br>-->
				Fullname: <input type = "text" name = "updatedFullname" value = <?php if(isset($_SESSION['fullname']))echo $_SESSION['fullname']; else echo "placeholder = 'Fullname'";?>><br>
				Facebook: <input type = "text" name = "updatedFacebook" value = "<?php if(isset($_SESSION['facebook']))echo $_SESSION['facebook'];?>" placeholder = "Facebook link"><br>
				Blog: <input type = "text" name = "updatedBlog" value = "<?php if(isset($_SESSION['blog']))echo $_SESSION['blog'];?>" placeholder = "Blog link"><br>
				Instagram: <input type = "text" name = "updateInstagram" value = "<?php if(isset($_SESSION['instagram']))echo $_SESSION['instagram'];?>" placeholder = "Instagram link"><br>
				
				<input type = "submit" value = "Save"><br>
				
			</form>
			<?php
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
						$updateNRIC = $_SESSION['nric'];
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
				if(isset($_POST['updatebirthday'])){
					$updatebirthday = (int)$_POST['updatebirthday'];
					$_SESSION['birthday'] = $updatebirthday;
				}else{
					if(isset($_SESSION['birthday'])){
						$updatebirthday = $_SESSION['birthday'];
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

					echo "Edits saved<br>";
					//echo "redirecting...";
					
				}else{
					//echo "error!";
				}
				
			?>
		</div>
	</body>
	<style>
		p{
			position:relative;
			top:100px;
		}
		#setting{
			position:relative;
			top:150px;
		}
		.displayresults{
			position:absolute;
			top:150px;
			left:600px;
			border:3px solid black;
			text-align:center;
			border-collapse: collapse;
		}
		th,td{
			border:1px solid grey;
			padding:10px;
		}
		.overview{
			position:absolute;
			top:200px;
			left:150px;
			border:3px solid black;
			text-align:center;
			border-collapse: collapse;
		}

		.blogLink{
			color:black;
		}
	</style>
</html>