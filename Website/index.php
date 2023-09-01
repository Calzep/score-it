<?php include"conn.php";?>

<!DOCTYPE html>
<html lang = "en">

<!-- score_it_homepage
Version 5 23/10/2021
by Caleb Eason /-->

  <head>
    <title>Score It - Home</title>

    <meta charset="utf-8"/>
    <meta name="description" content = "Musical arrangement service">
    <meta name="keyword" content ="music,arrangement,scores,request">
    <meta name="author" content = "Caleb Eason">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="style.css" rel="stylesheet" type="text/css" />

    <style>
      #loginButton {
        width: 150px;
        height: 35px;
        float: right;
        margin-right: 20px;
        margin-top: 25px;
        padding-bottom: 12px;
      }
      #loginButton2 {
        width: 150px;
        height: 50px;
        margin: auto;
        margin-top: 25px;
        padding: auto;
      }
      #parallaxImage1 {
        background-image: url("images/home_1.jpg");
        height: 300px;
        background-attachment: fixed;
        background-position: center -100px; /*Lowers the image by 100px to fit uner the header*/
        background-repeat: no-repeat;
        background-size:  cover;
      }
      #parallaxImage2 {
        background-image: url("images/home_2.jpg");
        height: 300px;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size:  cover;
      }
      #parallaxImage3 {
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
        
      /*Reduce the height of the images when the viewport is less than 800px*/
      @media only screen and (max-width: 800px) {
        #parallaxImage1 {
          height: 250px;
        }
        #parallaxImage2 {
          height: 250px;
        }
        #parallaxImage3 {
          height: 250px;
        }
      }
      /*Reduce the height of the images and increase the height of the text container when below 650px*/
      @media only screen and (max-width: 650px) {
        .textContainer {
          height: 350px;
        }
        #parallaxImage1 {
          height: 200px;
        }
        #parallaxImage2 {
          height: 200px;
        }
        #parallaxImage3 {
          height: 200px;
        }
      }
      /*Increase the height of the text container when below 550px*/
      @media only screen and (max-width: 550px) {
        .textContainer {
          height: 400px;
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
          <p class="p1">Login/Register</p>
          </div>
        </a>
        <!-- CONTENT -->
        <div><p class="h1">Score It</p></div>
      </div>
      <div id="parallaxImage1"></div>
      <div class="textContainer">
        <p class="h2">About this page</p>
        <p class="p2"> Welcome to Score It.  Score it is an independant musical arrangement service.  Our website 
            contains a large library of high quality musical arrangements, orchestrations and transcriptions, which you can 
            browse and download completely free of charge.  We also offer an arrangement service for you to request your
            own custom arrangements/transcriptions, also completely free of charge!
          </p>
      </div>
      <div id="parallaxImage2"></div>
      <div class="textContainer">
        <p class="h2">Why Sign Up?</p>
        <p class="p2">Creating an account will allow you full access to our online database of scores, which you
          can download for free!  You can also submit your own a resuests for custom arrangments or orchestrations.</p>
        <a href="login.php">
          <div id="loginButton2" class="button_green">
            <p class="p1">Sign Up</div>
        </a>
      </div>
      <div id="parallaxImage3"></div>
      <!-- FOOTER -->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>