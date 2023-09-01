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

//In order to submit a request a user must have added an email to their account. This checks
//if the user has added an email and reidrects the to the accounts page if they have not
if(strlen($_SESSION['Email']) == 0) {
?>
	<script>alert('You must add an email to your account in order to make a request');</script>
<?php
	header('Refresh:0; url=account.php');
}
?>

<?php
//When the submit button is pressed
if(isset($_POST['submitButton'])) {
    //Retrieve variables from form
	$title = $_POST['songTitle'];
	$composer = $_POST['composer'];
	$song_data = $_POST['songData'];
	$instrument_data = $_POST['instrumentData'];
	$arrangement_data = $_POST['arrangementData'];
	
    //Create a local variable for relevent session variables
	$username = $_SESSION['Username'];
	$email = $_SESSION['Email'];
	$FName = $_SESSION['FirstName'];
	$LName = $_SESSION['LastName'];
	
    //Test if a file has been uploaded
	if(!empty($_FILES['file']['name'])){
        //If a file is present:
        
		$uploadedFile = $_FILES['file']['name'];
		
        //folder path where uploads are stored	
		$target_path = "uploads/"; 
		
        //Creates a variable to hold the file's directory.	
		$target_file = $target_path . basename($_FILES['file']['name']); 
		
        //Move the uploaded file to the specified directory.
		move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
		
        //Append data to the requests table
		$data = $conn->query("INSERT INTO requests (title, composer, username, email, first_name
		, last_name, song_data, instrument_data, arrangement_data, resources) Values ('$title', 
		'$composer', '$username', '$email', '$FName', '$LName', '$song_data', '$instrument_data'
		, '$arrangement_data', '$uploadedFile')");
	}
	else{
        //If no file is present: append request, ommiting data for the resources field.
		$data = $conn->query("INSERT INTO requests (title, composer, username, email, first_name
		, last_name, song_data, instrument_data, arrangement_data) Values ('$title', 
		'$composer', '$username', '$email', '$FName', '$LName', '$song_data', '$instrument_data'
		, '$arrangement_data')");
	}
    //Check if the querry has run successfully. If it has, display an alert to inform the user their data
    //has been updated, Otherwise inform the user an error has occured.
	if($data){
?>	
		<script>alert('Your request has been submitted!');</script>
<?php
		
	} 
	else{
?>
		<script>alert('Invalid Submission');</script>
<?php
	}
}
?>

<!DOCTYPE html>
<html lang = "en">

<!-- score_it_RequestsPage
Version 5 29/10/2021
by Caleb Eason /-->

  <head>
    <title>Score It - Requests</title>

    <meta charset="utf-8"/>
    <meta name="description" content = "Musical arrangement service">
    <meta name="keyword" content ="music,arrangement,scores,request">
    <meta name="author" content = "Caleb Eason">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="style.css" rel="stylesheet" type="text/css" />

    <style>
      #image {
        background-image: url("images/home_1.jpg");
        height: 200px;
        background-position: fixed -100px;
        background-repeat: no-repeat;
        background-size: cover;
      }
      #container {
        width: 100%;
        height: 1450px;
        background-color: #000;
        margin: 0px;
      }
      #formContainer {
        width: 85%;
        height: 100%;
        margin: auto;
      }
      /* for the two entries at the top of the form.
        col-2 prevents below content from travelling upwards */
      #col-1 {
        width: 43%;
        height: 120px;
        float: left;
        margin: 0px;
      }
      #col-2 {
        width: 14%;
        height: 120px;
        float: left;
        margin: 0px;
      }
      #col-3 {
        width: 43%;
        height: 120px;
        float: right;
        margin: 0px;
      }
      .subContainer {
        width: 100%;
        height: 400px;
        margin: auto;
      }
      .h4 {
        color: #FFF;
        font-family: arial;
        font-size: 32px;
        text-align: center;
        margin: 0px;
        padding-top: 84px;
      }
      /* Changes the allignment of h2 for this page*/
      .h2 {
        text-align: left;
      }
      .entrybox2 {
        /*For a unknowen reason, setting the entry box width to 100% caused overflow */
        width: 97.5%;
        height: 30px;
        background-color: #fff;
      }
      .entrybox3 {
        width: 98.9%;
        height: 120px;
        background-color: #fff;
      }
      #submitButton {
        width: 150px;
        height: 50px;
        margin: auto;
        margin-top: 25px;
        padding: auto;
        display: block;
      }
      #uploads {
        width: 100%;
        color: #fff;
        padding-top: 20px;
      }
      /* Media queries*/
        
      /* Increases page height as screen gets smaller */
      @media only screen and (max-width: 1250px) {
        #container {
          height: 1500px;
        }
      }
      @media only screen and (max-width: 800px) {
        #container {
          height: 1600px;
        }
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
        <a href="#">
          <div id="rightLink"><p class="p3">Request</p></div>
        </a>
      </div>
      <!-- CONTENT -->
      <div id="image">
          <p class="h4">Request an Arrangement</p>
      </div>
      <div id="container">
        <p class="p2">Fill out the form below to request an arrangement.  Provide as much details as you can for each section.  If you have not yet added an email to your account, please do so before requesting an arrangement</p>
        <br>
        <div id="formContainer">
          <!-- Form for submitting requests-->
          <form name="RequestsForm" method="post" action="" enctype="multipart/form-data">
            <p class="h2">Score Details</p>
            <div id="col-1"> <!-- left column -->
              <label for="songTitle"><p class="l1">Song/Work Title</p></label>
              <input type="text" id="songTitle" class="entrybox2" name="songTitle" required="required" placeholder="Title">
            </div>
            <div id="col-2"></div> <!-- spacer -->
            <div id="col-3"> <!-- right column -->
              <label for="composer"><p class="l1">Composer/Artist</p></label>
              <input type="text" id="composer" class="entrybox2" name="composer" required="required" placeholder="Composer">
            </div>
            <label for="songData"><p class="l1">Please provide some information on the piece of music you want arranged.  You can upload any resources you wish to provide later in the process, or you can paste a link to online resources here.</p></label>
            <input type="text" id="songData" class="entrybox3" name="songData" required="required">
            <br>
            <br>
            <p class="h2">Required Instruments</p>
            <label for="instrumentData"><p class="l1">Please provide detail on the instrument(s) you are arranging for.   For an ensemble, list each instrument you want to use, include any necessary detail about ability level/ranges for specific players.</p></label>
            <input type="text" id="instrumentData" class="entrybox3" name="instrumentData" required="required">
            <br>
            <br>
            <p class="h2">Arrangement Details</p>
            <label for="arrangementData"><p class="l1">Provide some detail on your desired arrangement.  Are you looking for a simple orchestration or transcription of an existing work?  Or do you want a reimagination of a peice, such as a change of genre/style?</p></label>
            <input type="text" id="arrangementData" class="entrybox3" name="arrangementData" required="required">
            <br>
            <br>
            <br>
            <p class="h2">Upload Resources</p>
            <label for="file"><p class="l1">If you have any resources you wish to provide you can upload them as a single file below.</p></label>
            <input type="file" id="uploads" name="file">
            <br>
            <br>
            <br>
            <br>
            <input type="submit" name="submitButton" id="submitButton" class="button_green" value="Submit">
          </form>
        </div>
      </div>
      <!-- FOOTER -->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>