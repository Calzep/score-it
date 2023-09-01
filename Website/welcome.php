<?php
session_start();
include"conn.php";

error_reporting(0); //Stops errors displaying
?>

<?php
//Check for a valid user_id in the Session Variable $UserID from the login page,
// else redirect the user back to the login page
if(isset($_SESSION['UserID'])){
}
else {
	header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang = "en">

<!-- score_it_welcomePage
Version 1 12/10/2021
by Caleb Eason /-->

  <head>
    <title>Score It - Welcome</title>

    <meta charset="utf-8"/>
    <meta name="description" content = "Musical arrangement service">
    <meta name="keyword" content ="music,arrangement,scores,request">
    <meta name="author" content = "Caleb Eason">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="style.css" rel="stylesheet" type="text/css" />

    <style>
      #parallaxImage1 {
        background-image: url("images/home_1.jpg");
        height: 300px;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size:  cover;
      }
      #parallaxImage2 {
        background-image: url("images/home_3.jpg");
        height: 300px;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size:  cover;
      }
      .textContainer {
        background: #000;
        width: 100%;
        height: 300px;
      }
        
      /* Media Queries */
        
      /*Reduce the size of the images as the screen gets smaller*/
      @media only screen and (max-width: 800px) {
        #parallaxImage1 {
          height: 250px;
        }
        #parallaxImage2 {
          height: 250px;
        }
      @media only screen and (max-width: 650px) {
        #parallaxImage1 {
          height: 200px;
        }
        #parallaxImage2 {
          height: 200px;
        }
    </style>

  </head>
  <body>
    <div id="main"> <!--Container for the whole site/-->
      <!-- HEADER -->
      <div id="header">
        <div id="logo"><img src="images/Logo_border.jpg" alt="logo" width="100" height="100"></div>
        <a href="account.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="loginButton" class="button_green">
          <p class="p1">My Account</p>
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
      <div id="parallaxImage1"></div>
      <div class="textContainer">
        <p class="h2">Welcome</p>
        <p class="p2">Thank you for choosing Score It.  Click the 'browse' tab at the top of the page to view our arrangements database.  Click on the 'requests' tab to submit a request.  You can edit your details or logout by clicking the 'account' button.</p>
      </div>
      <div id="parallaxImage2"></div>
      <!-- FOOTER -->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>