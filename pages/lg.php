<?php
	Session_start();
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
	<head>
		<title>
			<?php echo strtoupper($_SESSION['lg']);?> page
		</title>
		<link rel = "stylesheet" type = "text/css" href="/smua2/css/style.css">
		<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		
		<script>
			$(document).ready(function(){
				$("div").hide();
				$(".menu").show();
				$(".link").show();
				$(".content").show();
				$(".foreground").show();

				$(".tab1").click(function(){
					$("div").hide();
					$(".menu").show();
					$(".link").show();
					$("#aboutus").fadeIn();
				});
				$(".tab2").click(function(){
					$("div").hide();
					$(".menu").show();
					$(".link").show();
					$("#individualProfile").fadeIn();
					$(".result").fadeIn();

				});
				$(".tab4").click(function(){
					$("div").hide();
					$(".menu").show();
					$(".link").show();
					$("#photogallery").fadeIn();
					$("#container").fadeIn();
					
				});
				$("a").on(function(){
					$("a").fadeTo(0.4);
				});

				$(window).scroll(function(){
					if ($(window).scrollTop() >= 50) {
      					$('head').addClass('menu');
      				} else {
				       $('head').removeClass('menu');
				    }
				});

			});
		</script>
		
		<div class = "menu">
			<ul>
				<li class = "blogname"><?php echo strtoupper($_SESSION['lg']);?></li>
				<div class = "link">
					<li class = "tab0"><A href = "http://localhost:8888/Self/lg.php">HOME</A></li>&nbsp
					<li class = "tab1"><A href = "#aboutus">ABOUT</A></li>&nbsp
					<li class = "tab2"><A href = "#individualProfile">INDIVIDUAL</A></li> &nbsp<!--This will have drop down option of the people in the the group -->
					<li class = "tab3"><A href = "https://www.facebook.com/groups/194097773966901/">FBPAGE</A></li> &nbsp <!--This will direct user to facebook page -->
					<li class = "tab4"><A href = "#photogallery">PHOTOS</A></li>&nbsp <!--This will show all the photos uploaded, faded in, and displayed-->
					<li class = "tab5"><A href = "">TIMETABLE</A></li>&nbsp
					<li class = "tab6"><A href = "">FINANCE</A></li>&nbsp
					<!--<li class = "tab7"><A href = "Register.php">Add members</A></li> This will bring them to the registration page, with preset lgname: whichever the link was clicked from-->
					<li class = "logout"><A href = "logout.php">LOGOUT</A></li> <!--This will end the sessions and bring them back to log in page -->
				</div>
			</ul><br>
		</div>
	</head>
	<body>
		<div class = "foreground">
			<img src="http://www.3dwallhd.com/wp-content/uploads/2012/11/widescreen-wallpaper.jpg" width="100%" height="450px" margin ="0px" alt="A lg photo for a front page">
		</div>

		<div class = "content">
		</div>

		<div id = "aboutus">
			<?php
				$stmt = $conn->prepare("select description from lg_description where lg = ?");
				$stmt->bind_param("s",$lg);
				$lg = $_SESSION['lg'];
				$stmt->execute();
				mysqli_stmt_bind_result($stmt, $description);
				
				while(mysqli_stmt_fetch($stmt)){
					if(strlen($description) > 0){
						echo "<p class = 'infoAboutUs'>";
						echo $description;
						echo "</p>";
					}else{
						echo "<p class = 'infoAboutUs'>";
						echo "something abt the lg in <a href = '#changeInfo'>this</a> space!";
						echo "</p>";
					}
				}
				
				
			?>
		</div>
		<div id = "individualProfile" >
			<form id = "myform" method = "post" ACTION = "<?php echo $_SERVER['PHP_SELF']?>">
				<?php
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
			
		</div>
		<div class = "result">
				<?php
					$mysqli = "select * from userdb where username = ? and lgname = ?";
					$stmt = $conn->prepare($mysqli);
					$stmt->bind_param('ss',$user, $lg);
					$lg = $_SESSION['lg'];
					if(isset($_POST['selectedName'])){
						$user = $_POST['selectedName'];
						$stmt->execute();
						mysqli_stmt_bind_result($stmt,$user,$pass,$fullname,$birthday,$contact,$add,$nric,$shirtsize,$lgname,$description);
						echo "<table class= 'memberresult'>";
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
			</div>

		<div id = "photogallery">
			 <img src='image-folder/image-1'.gif id='collage-one' />
			 <img src='image-folder/image-2'.gif id='collage-two' />
			 <img src='image-folder/image-3'.gif id='collage-three' />
			 <img src='image-folder/image-4'.gif id='collage-four' />
			 <img src='image-folder/image-5'.gif id='collage-five' />
			 <img src='image-folder/image-6'.gif id='collage-six' />
		</div>
	</body>
	<footer>
		<!--© <?php echo date("Y")." Xueyong"?>-->
	</footer>
	<style>
		.fixed-header{
			background-color: #F0F0F0;
			height:65px;
			display:inline-block;
			width: 100%;
			visibility: hidden;
			top:0px;
			left:0px;
			border:1px solid #ccc;
		}
		#collage-one,#collage-two,#collage-three,#collage-four,
		#collage-five,#collage-six,#collage-seven{
			width:168px;
			height:224px;
			padding:10px;
			background:#eee;
			border-radius:20px;
			-moz-border-radius:20px;
			-webkit-border-radius:20px;
			position:absolute;
		}
	</style>
</html>