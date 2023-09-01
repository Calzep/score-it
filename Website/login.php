<?php 
session_start();
include"conn.php";

error_reporting(0); //Stops errors displaying
?>

<?php
//CREATE NEW ACCOUNT

//When newAccoutButton is pressed:
if(isset($_POST['newAccountButton'])) {	
	//retrieve data from entry boxes
    $username = $_POST['username'];	
	$password = $_POST['password'];
	
	//Test if the entered username is already present in the database
	$result = $conn->query("select id from members where username = '$username'");
	if($result->num_rows == 0) {
	//If username is not already in database: Append username and password
		$sql = $conn->query("INSERT INTO members (username, password) 
		Values('$username', '$password')");
		
		//Once user has been added, initiate login process
		$result = $conn->query("select id from members
		where username='$username'");
		$row = $result->fetch_array();
		$id = $row['id'];
		
		//Session vaiables, new users won't have any information such as email so is not needed.
		$_SESSION['UserID'] = $row['id'];
		$_SESSION['Username'] = '$username';
		$_SESSION['Password'] = '$password';
		
		//Redirect to welcome
?>
		<script>window.location ="welcome.php?id=<?php echo $id;?>";</script>
<?php
	} 
	else {
	//If username is already in database: Display alert and do not append duplicate user.
?>
		<script>alert('There is already an account associated with this username!');</script>
<?php
	}
}
?>

<?php
//LOGIN IN

//When loginButton2 is pressed
if(isset($_POST['loginButton2'])) {
    //retrieve data from entry boxes
	$loginUsername = $_POST['username'];
	$loginPassword = $_POST['password'];
    
    //Check data against members table
	$result = $conn->query("select * from members
	where username='$loginUsername' and password='$loginPassword'");
	$row = $result->fetch_array();
	  
	$username = $row['username'];
	$password = $row['password'];
	$id = $row['id'];
	  
	//Check user input against database
	if($loginUsername==$username && $loginPassword==$password){
		//If inputs match the database then:
        //Establish Session variables
		$_SESSION['UserID'] = $id;
		$_SESSION['Username'] = $row['username'];
		$_SESSION['Password'] = $row['password'];
		$_SESSION['Email'] = $row['email'];
		$_SESSION['FirstName'] = $row['first_name'];
		$_SESSION['LastName'] = $row['last_name'];
		$_SESSION['Admin'] = $row['admin'];
		
		//Test if user is an admin, if so redirect to admin page,
        //otherwise send them to the wecome page
		if($_SESSION['Admin']==1){
?>
			<script>window.location ="admin.php?id=<?php echo $id;?>";</script>
<?php
		}
		else {
?>
			<script>window.location ="welcome.php?id=<?php echo $id;?>";</script>
<?php
		}
	}
	else{
        //If input does not match the database, display an alert
?>
		<script>alert('Incorrect Username or Password');</script>
<?php
		}
}
?>
<!DOCTYPE html>
<html lang = "en">

<!-- score_it_loginPage
Version 9 24/10/2021
by Caleb Eason /-->

  <head>
    <title>Score It - Login</title>

    <meta charset="utf-8"/>
    <meta name="description" content = "Musical arrangement service">
    <meta name="keyword" content ="music,arrangement,scores,request">
    <meta name="author" content = "Caleb Eason">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="style.css" rel="stylesheet" type="text/css" />

    <style>
    #main {
      height: 99vh;
      width: 100%;
      background-color: #1d1d1d;
    }
    #loginButton2 {
        width: 125px;
        height: 45px;
        float: right;
        margin-top: 30px;
        padding: auto;
        color: #000;
        font-family: arial;
        font-size: 16px;
        text-align: center;
        border: 2px solid #101010;
      }
    #newAccountButton {
        width: 100%;
        height: 45px;
        margin-top: 30px;
        padding: auto;
        color: #fff;
        font-family: arial;
        font-size: 16px;
        text-align: center;
      }
      #container2 {
        width: 275px;
        margin: auto;
      }
      #footer {
        position:absolute;bottom:0; /* Stick to the bottom of the page */
      }
      /* Enables the footer stick to the bottom of the page */
      #main {
        position:relative;
      }
    </style>
  </head>
    
  <body>
    <div id="main"> <!--Container for the whole site/-->
      <!-- HEADER -->
      <div id="header">
        <div id="logo"><img src="images/Logo_border.jpg" alt="logo" width="100" height="100"></div>
        <a href="index.php">
          <div id="loginButton" class="button_green">
          <p class="p1">Back</p>
          </div>
        </a>
        <div id="siteTitle"><p class="h1">Score It</p></div>
      </div>
      <!-- CONTENT -->
      <div id="container2">
        <p class="h3" text-align="center">Login or Create an Account</p>
        <!-- Form for logging in/signing up -->
        <form name="RegisterForm" method="post" action="" enctype="multipart/form-data"> <!-- Login form -->
          <label for="username"><p class="l1">Username</p></label>
          <input type="text" id="username" class="entrybox" name="username" required="required" placeholder="Username">
          <label for="password"><p class="l1">Password</p></label>
          <input type="text" id="password" class="entrybox" name="password" required="required" placeholder="Password">
          <input type="submit" id="loginButton2" class="button_green" name="loginButton2" value="Login">
          <input type="submit" id="newAccountButton" class="button_black" name="newAccountButton" value="Create new account">
        </form>
      </div>
      <!-- FOOTER -->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>