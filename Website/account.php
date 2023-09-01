<?php
session_start();
include"conn.php";

error_reporting(0); //Stops errors displaying
?>

<?php
//Check for a valid user_id in the Session Variable $UserID from the login page,
// else redirect the user back to the login page
if(isset($_SESSION['UserID'])) {
}
else {
	header('Location: login.php');
}

//Create a local varible for the UserID session variable
$user = $_SESSION["UserID"];
  
//Select all values from the members table where the user_id matches the variable $user  
// and store the values in an array, and assign this to the variable $row
//Used for populating entry boxes with user data
$result = $conn->query("select * from members where id='$user'");
$row = $result->fetch_array();	
	
?>

<?php
//When the Update profile button is pressed
 if(isset($_POST['saveDetails'])) {
	 
    //Assign a local variable for username and user id
	$id=$row['id'];
	$oldUsername=$row['username'];
	
	//Create a local variable for each entry box
	$newUsername = $_POST['username'];
	$newPassword = $_POST['password'];
	$newEmail = $_POST['email'];
	$newFName = $_POST['firstName'];
	$newLName = $_POST['lastName'];
	
	//Test if username is already present in the database.  
	$result = $conn->query("select id from members where username = '$newUsername'");
	
	//This if statement will run if the user enters a unique username that is 
	//not already in the database, or if they have not changed their username
    //If the username is unchanged, it will match against itsself, so the OR statement is reqiuired.
	if($result->num_rows == 0 || $newUsername==$oldUsername) {
		//If username is not already in database: Update details

		$data = $conn->query("UPDATE members SET username = '$newUsername', password = '$newPassword'
		, email = '$newEmail', first_name = '$newFName', last_name = '$newLName' where id = $user");	

		//Check if the querry has run successfully. If it has, display an alert to inform the user their data
		//has been updated and update session variables.  Otherwise inform the user an error has occured.
		if($data){
			$_SESSION['Username'] = $newUsername;
			$_SESSION['Password'] = $newPassword;
			$_SESSION['Email'] = $newEmail;
			$_SESSION['FirstName'] = $newFName;
			$_SESSION['LastName'] = $newLName;
?>	
			<script>alert('Your details have been updated');</script>
<?php
		
		} 
		else{
?>
			<script>alert('Invalid Update');</script>
<?php
		}
	}
	else {
	//If username is already in the database: Display alert and do not update details.
?>
		<script>alert('There is already an account associated with this username!');</script>
<?php
	}
  }
?>

<!DOCTYPE html>
<html lang = "en">

<!-- score_it_accountsPage
Version 5 24/10/2021
by Caleb Eason /-->

  <head>
    <title>Score It - My Account</title>

    <meta charset="utf-8"/>
    <meta name="description" content = "Musical arrangement service">
    <meta name="keyword" content ="music,arrangement,scores,request">
    <meta name="author" content = "Caleb Eason">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="style.css" rel="stylesheet" type="text/css" />

    <style>
      #container {
        width: 100%;
        height: 600px;
        background-color: #000;
        margin: 0px;
      }
      /* For formatting the form */
      .col-1 {
        width: 50%;
        height: 100%;
        float: left;
        margin: 0px;
      }
      .col-2 {
        width: 50%;
        height: 100%;
        float: right;
        margin: 0px;
      }
      #subContainer1 {
        width: 250px;
        height: 100%;
        margin: auto;
      }
      #subContainer2 {
        width: 250px;
        height: 100%;
        margin: auto;
      }
        
      /* Used to change the padding on varous elements*/
      #paddingModifier {
        padding-top: 10px;
      }
      #saveDetails {
        width: 100%;
        height: 45px;
        margin-top: 43px;
        padding: auto;
        color: #fff;
        font-family: arial;
        font-size: 16px;
        text-align: center;
      }
      /* Media Queries */
      
      /* When the screen is below 600px, stack the two columns on top of each other */
      @media only screen and (max-width: 600px) {
        .col-1 {
          width: 100%;
        }
        .col-2 {
          width: 100%;
        }
        #container {
          height: 650px;
        }
      }
      /* when the screen is above 1500px, move the form elements closer to the center. */
      @media only screen and (min-width: 1500px) {
        #subContainer1 {
          padding-left: 100px;
        }
        #subContainer2 {
          padding-right: 100px;
        }
      }
    </style>

  </head>
  <body>
    <div id="main"> <!--Container for the whole site/-->
      <!-- HEADER -->
      <div id="header">
        <div id="logo"><img src="images/Logo_border.jpg" alt="logo" width="100" height="100"></div>
        <a href="login.php">
          <div id="loginButton" class="button_green">
          <p class="p1">Logout</p>
          </div>
        </a>
        <div><p class="h1">Score It</p></div>
      </div>
      <!-- NAV-BAR -->
      <div id="navBar">
        <a href="arrangements.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="leftLink"><p class="p3">Browse</p></div>
        </a>
        <a href="requests.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="rightLink"><p class="p3">Request</p></div>
        </a>
      </div>
        <!-- CONTENT -->
        <div id="container">
          <p class="h2">Your Details</p>
          <!-- Form for updating details -->
          <form name="UpdateForm" method="post" action="" enctype="multipart/form-data">
            <div class="col-1"> <!-- left column -->
              <div id="subContainer1">
                <label for="username"><p class="l1">Username</p></label>
                <input type="text" id="username" class="entrybox" name="username" required="required" placeholder="Username" value="<?php echo $_SESSION["Username"]; ?>">
                <label for="password"><p class="l1">Password</p></label>
                <input type="text" id="password" class="entrybox" name="password" required="required" placeholder="Password" value="<?php echo $_SESSION["Password"]; ?>">
                <label for="email"><p class="l1">Email</p></label>
                <input type="text" id="email" class="entrybox" name="email" placeholder="Email Address" value="<?php echo $_SESSION["Email"]; ?>">
              </div>
            </div>
            <div class="col-2"> <!-- right column -->
              <div id="subContainer2">
                <label for="firstName"><p class="l1">First Name</p></label>
                <input type="text" id="firstName" class="entrybox" name="firstName" placeholder="First Name" value="<?php echo $_SESSION["FirstName"]; ?>">
                <label for="lastName"><p class="l1">Last Name</p></label>
                <input type="text" id="lastName" class="entrybox" name="lastName" placeholder="Last Name" value="<?php echo $_SESSION["LastName"]; ?>">
                <input type="submit" id="saveDetails" name="saveDetails" class="button_black" value="Update Details">
              </div>
            </div>
          </form>
        </div>
      <!-- FOOTER -->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>