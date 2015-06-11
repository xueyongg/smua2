<?php
session_start();
$servername = "localhost";
$connUsername = "root";
$connPassword = "root";
$conn = new mysqli($servername, $connUsername, $connPassword, 'xyDB');

/*
  if($conn -> connect_error){
  die("Connection failed: ". $conn->connect_error);
  }else{
  echo "Connect Successfully.<br>";
  } */
$stmt = $conn->prepare("select blog, facebook, instagram from reference_table r where username = ?");
$stmt->bind_param("s", $username);
$username = $_SESSION['username'];
$stmt->execute();
mysqli_stmt_bind_result($stmt, $blog, $facebook, $instagram);
while (mysqli_stmt_fetch($stmt)) {
    $_SESSION['blog'] = $blog;
    $_SESSION['facebook'] = $facebook;
    $_SESSION['instagram'] = $instagram;
}

$stmt = $conn->prepare("select u.username,fullname,birthday,contactno,nric,shirtsize,address,description
									from reference_table r, userdb u where u.username = r.username and u.username = ?;");
$stmt->bind_param("s", $username);
$username = $_SESSION['username'];
$stmt->execute();
mysqli_stmt_bind_result($stmt, $user, $full, $birth, $contact, $nric, $shirtsize, $add, $des);
while (mysqli_stmt_fetch($stmt)) {
    $_SESSION['birthday'] = $birth;
    $_SESSION['ContactNumber'] = $contact;
    $_SESSION['nric'] = $nric;
    $_SESSION['size'] = $shirtsize;
    $_SESSION['address'] = $add;
    $_SESSION['description'] = $des;
}
?>
<html>
    <head>
        <link rel = "stylesheet" text = "text/css" href = "/smua2/css/Style.css">
        <script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".mainbody").hide();
                $(".menu").show();
                $(".link").show();

                $(".tab0").click(function () {
                    $(".mainbody").hide();
                    $(".menu").show();
                    $(".link").show();
                    $(".welcomemessage").fadeIn();
                });

                $(".tab4").click(function () {
                    $(".mainbody").hide();
                    $(".welcomemessage").hide();
                    $(".menu").show();
                    $(".link").show();

                    $("#aboutme").fadeIn();
                });
                $(".tab6").click(function () {
                    $(".mainbody").hide();
                    $("p").hide();
                    $(".menu").show();
                    $(".link").show();
                    $("#uploadfunction").fadeIn();
                });
                $(".tab7").click(function () {
                    $(".mainbody").hide();
                    $("p").hide();
                    $(".menu").show();
                    $(".link").show();
                    $("#setting").fadeIn();
                });
                $("#settingsaved").click(function () {
                    location.reload();
                });
                $(".changeinfobutton").click(function () {
                    $(".mainbody").hide();
                    $(".welcomemessage").hide();
                    $(".menu").show();
                    $(".link").show();
                    $("#aboutme").show();
                    $(".infoAboutMe").show();
                    $("#changeInfo").show();
                    $(".updateInfo").fadeIn();
                });
                $("#settingsaved").click(function () {
                    location.reload();
                });


            })
        </script>


    <div class = "menu">
        <?php
        if (strcmp($username, "Admin") == 0)
            echo "<meta http-equiv='refresh' content='0;url=AdminReferenceLink.php'>";
        ?>

        <ul>
            <li class = "blogname"><a href = ><?php echo strtoupper($_SESSION['fullname']); ?></a></li>
            <div class = "link">
                <li class = "tab0"><A href = >HOME</A></li>
                <li class = "tab1"><A target = "_blank" href = <?php echo $_SESSION['blog'] ?>>BLOG</A></li>&nbsp 
                <li class = "tab2"><A target = "_blank" href = <?php echo $_SESSION['facebook'] ?>>FB</A></li>&nbsp 
                <li class = "tab3"><A target = "_blank" href = <?php if (isset($_SESSION['instagram'])) echo $_SESSION['instagram'];
        else echo"" ?>>INSTAGRAM</A></li>&nbsp 
                <li class = "tab4"><A href = "#aboutme">ABOUT</A></li>&nbsp 
                <li class = "tab5"><A href = 'lg.php'><?php echo strtoupper($_SESSION['lg']); ?></A></li>&nbsp 
                <li class = "tab6"><A href = "#uploadfunction">UPLOAD FILE</A></li>&nbsp 
                <li class = "tab7"><A href = '#setting'>SETTING</A></li>&nbsp
                <li class = "logout"><A href = "logout.php">LOGOUT</A></li><br>
            </div>
        </ul><br>
    </div>

    <ul>
        <div class = "link">
            <li class = "side1"><a href= "">hi</a></li><br>
            <li class = "side2"><a href= "">1</a></li><br>
            <li class = "side2"><a href= "">2</a></li><br>
            <li class = "side2"><a href= "">3</a></li><br>
            <li class = "side2"><a href= "">4</a></li><br>
            <li class = "side2"><a href= "">5</a></li><br>
        </div>
    </ul>

    <p class ="welcomemessage">Welcome, <?php echo $_SESSION['fullname']; ?><br></p>

</head>
<body>
    <div class ="mainbody">
        <div id = "aboutme">
            <?php
            $stmt = $conn->prepare("select description from userdb where username = ?");
            $stmt->bind_param("s", $username);
            $username = $_SESSION['username'];
            $stmt->execute();
            mysqli_stmt_bind_result($stmt, $description);

            while (mysqli_stmt_fetch($stmt)) {
                if (strlen($description) > 0) {
                    echo "<p class = 'infoAboutMe'>";
                    echo $description;
                    echo "</p>";
                } else {
                    echo "<p class = 'infoAboutMe'>";
                    echo "Something about me here in <span class = 'changeinfobutton'><a href = '#changeInfo' >this</a></span> space!<br>";
                    echo "</p>";
                }
            }
            ?>
        </div>

        <div id = "uploadfunction">
            <form method = "post" Action = "<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <input type = "file" name = "fileToUpload" id = "fileToUpload">
                <input type = "submit" value = "upload" name = "submit">

                <div class = 'uploadprocess'>
                    <?php

                    function customError($errno, $errstr) {
                        echo "<b> error: </b> [$errno] $errstr </br>";
                    }

                    set_error_handler("customError");

                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    //checking if the file is fake or not
                    if (isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        //echo "Image has been upload -" . $check["mime"] . ".<br>";
                        $uploadOk = 1;
                    } else {
                        echo "Upload is unsuccessful!";
                        $uploadOk = 0;
                    }

                    //checking file existence
                    if (file_exists($target_file)) {
                        echo "This file has already been uploaded<br>";
                        $uploadOk = 0;
                    }

                    //checking file size
                    if ($_FILES["fileToUpload"]["size"] > 5000000) {
                        echo "File is too big to be uploaded.";
                        $uploadOk = 0;
                    }

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    if ($uploadOk == 0) {
                        echo "Sorry, the file was not uploaded.";
                    } else {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            echo "File " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded";
                            //echo "<meta http-equiv='refresh' content='2;url=MainPage.php'>";
                        } else {
                            echo "Sorry, upload error.";
                        }
                    }
                    ?>
                </div>

        </div>
        <div id ="setting">
            <?php
            $updatedFullname = $updatedBlog = $updatedFacebook = $updateContactNumber = $updateNRIC = $updateShirtSize = $mysql = "";
            $username = $_SESSION['username'];
            if (isset($_POST['updatedFullname'])) {
                $updatedFullname = $_POST['updatedFullname'];
                $_SESSION['fullname'] = $updatedFullname;
            } else {
                if (isset($_SESSION['fullname']))
                    $updatedFullname = $_SESSION['fullname'];
            }
            if (isset($_POST['updatedBlog'])) {
                $updatedBlog = $_POST['updatedBlog'];
                $_SESSION['blog'] = $updatedBlog;
            } else {
                if (isset($_SESSION['blog']))
                    $updatedBlog = $_SESSION['blog'];
            }
            if (isset($_POST['updatedFacebook'])) {
                $updatedFacebook = $_POST['updatedFacebook'];
                $_SESSION['facebook'] = $updatedFacebook;
            } else {
                if (isset($_SESSION['facebook']))
                    $updatedFacebook = $_SESSION['facebook'];
            }
            if (isset($_POST['updatedInstagram'])) {
                $updatedInstagram = $_POST['updatedInstagram'];
                $_SESSION['instagram'] = $updatedInstagram;
            } else {
                if (isset($_SESSION['instagram'])) {
                    $updatedInstagram = $_SESSION['instagram'];
                }
            }
            if (isset($_POST['updateContactNumber'])) {
                $updateContactNumber = $_POST['updateContactNumber'];
                $_SESSION['contactNumber'] = $updateContactNumber;
            } else {
                if (isset($_SESSION['contactNumber'])) {
                    $updateContactNumber = $_SESSION['ContactNumber'];
                }
            }
            if (isset($_POST['updateNRIC'])) {
                $updateNRIC = $_POST['updateNRIC'];
                $_SESSION['nric'] = $updateNRIC;
            } else {
                if (isset($_SESSION['nric'])) {
                    $updateNRIC = $_SESSION['nric'];
                }
            }
            if (isset($_POST['updateShirtSize'])) {
                $updateShirtSize = (int) $_POST['updateShirtSize'];
                $_SESSION['size'] = $updateShirtSize;
            } else {
                if (isset($_SESSION['size'])) {
                    $updateShirtSize = $_SESSION['size'];
                }
            }
            if (isset($_POST['updatebirthday'])) {
                $updatebirthday = $_POST['updatebirthday'];
                $_SESSION['birthday'] = $updatebirthday;
            } else {
                if (isset($_SESSION['birthday'])) {
                    $updatebirthday = $_SESSION['birthday'];
                }
            }
            ?>

            <form method ="post" Action = "<?php echo $_SERVER['PHP_SELF'] ?>">
                    <!--Username: <input type = "text" name = "updatedUsername" value = <?php if (isset($_SESSION['username'])) echo $_SESSION['username'];
            else echo "placeholder = 'Username'"; ?>><br>-->
                Fullname: <input type = "text" name = "updatedFullname" value = <?php if (isset($_SESSION['fullname'])) echo $_SESSION['fullname'];
            else echo "placeholder = 'Fullname'"; ?>><br>
                Facebook: <input type = "text" name = "updatedFacebook" value = "<?php if (isset($_SESSION['facebook'])) echo $_SESSION['facebook']; ?>" placeholder = "Facebook link"><br>
                Blog: <input type = "text" name = "updatedBlog" value = "<?php if (isset($_SESSION['blog'])) echo $_SESSION['blog']; ?>" placeholder = "Blog link"><br>
                Instagram: <input type = "text" name = "updateInstagram" value = "<?php if (isset($_SESSION['instagram'])) echo $_SESSION['instagram']; ?>" placeholder = "Instagram link"><br>
                birthday: <input type="date" name = "updatebirthday" value = "<?php if (isset($_SESSION['birthday'])) echo $_SESSION['birthday']; ?>"><br>
                contact No: <input type = "text" name = "updateContactNumber" value = "<?php if (isset($_SESSION['contactNumber'])) echo $_SESSION['contactNumber']; ?>" placeholder = "91234567"><br>
                NRIC: <input type = "text" name = "updateNRIC" value = "<?php if (isset($_SESSION['nric'])) echo $_SESSION['nric']; ?>" placeholder = "S1234567A"><br>
                Shirt Size: <input type = "text" name = "updateShirtSize" value = "<?php if (isset($_SESSION['size'])) echo $_SESSION['size']; ?>" placeholder = "Shirt size"><br>
                Address: <input type = "text" name = "updateAddress" value = "<?php if (isset($_SESSION['address'])) echo $_SESSION['address']; ?>" placeholder = "Address"><br>

                <input type = "submit" value = "Save" id = "settingsaved"><br>

            </form>
            <?php
            $mysql = "update reference_table set facebook = ?, blog = ?, Instagram = ? where username = ? ";
            $stmt = $conn->prepare($mysql);
            $stmt->bind_param('ssss', $updatedFacebook, $updatedBlog, $updatedInstagram, $username);
            $stmt->execute();
            mysqli_stmt_store_result($stmt);
            $mysql = "update userdb set contactNo = ?, NRIC = ?, shirtSize = ?, birthday = ? where username = ? ";
            $secstmt = $conn->prepare($mysql);
            $secstmt->bind_param('ssiss', $updateContactNumber, $updateNRIC, $updateShirtSize, $updatebirthday, $username);
            $secstmt->execute();
            mysqli_stmt_store_result($secstmt);
            if (mysqli_stmt_affected_rows($secstmt) > 0) {

                echo "Edits saved<br>";
                //echo "redirecting...";
            } else {
                //echo "error!";
            }
            ?>
        </div>

        <div id= "changeInfo">
            <form method = "post" action = "<?php echo $_SERVER['PHP_SELF'] ?>">
                <div class = "updateInfo">
                    <input type = "textarea" rows = "4" cols = "40" name = "updatePara" placeholder="something about me here..">
                    <input type = "submit" value = "Save" id = "settingsaved">
                </div>
            </form>
            <div class = "savingdetails">
                <?php
                if (isset($_POST['updatePara'])) {
                    $mysql = "update userdb set description = ? where username = ? ";
                    $stmt = $conn->prepare($mysql);
                    $stmt->bind_param('ss', $updatePara, $username);
                    $updatePara = $_POST['updatePara'];
                    $stmt->execute();
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_affected_rows($secstmt) > 0)
                        echo "Edits saved<br>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
<style>
    .infoAboutMe{
        position:relative;
        top:150px;
    }

    #uploadfunction{
        position:relative;
        top:150px;
    }

    #setting{
        position:relative;
        top:150px;
    }

    #changeInfo{
        position:relative;
        top:250px;
    }
</style>

<script src="/path/to/masonry.pkgd.min.js"></script>

</html>
