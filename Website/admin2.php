<?php
session_start();
include"conn.php";

error_reporting(0); //Stops errors displaying
?>

<?php
//Check if the user is a a valid admin with the admin session variable
//else redirect the user back to the login page
if($_SESSION['Admin']==1){
}
else {
	header('Location: login.php');

}
?>

<?php
//When the Upload Score button is pressed
 if(isset($_POST['uploadScore'])) {
	
	//Create a local variable for each entry box
	$title = $_POST['title'];
	$composer = $_POST['composer'];
	
	//Test if a file has been uploaded
    if(!empty($_FILES['thumbnail']['name'])){
        //If a file is present:
        
		$uploadedThumbnail = $_FILES['thumbnail']['name'];
		
        //folder path where uploads are stored	
		$target_path = "scores/"; 
		
        //Creates a variable to hold the file's directory.	
		$target_file = $target_path . basename($_FILES['thumbnail']['name']); 
		
        //Move the uploaded file to the specified directory.
		move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file);
	}
	if(!empty($_FILES['score']['name'])){
        //If a file is present:
        
		$uploadedScore = $_FILES['score']['name'];
		
        //folder path where scores are stored	
		$target_path = "scores/"; 
		
        //Creates a variable to hold the file's directory.	
		$target_file = $target_path . basename($_FILES['score']['name']); 
		
        //Move the uploaded file to the specified directory.
		move_uploaded_file($_FILES['score']['tmp_name'], $target_file);
		
        
	}
	//Append data to the scores table
	$data = $conn->query("INSERT INTO scores (title, composer, thumbnail, file) Values ('$title', 
	'$composer','$uploadedThumbnail','$uploadedScore')");
	
    //Check if the querry has run successfully. If it has, display an alert to inform the user their data
    //has been updated, Otherwise inform the user an error has occured.
	if($data){
?>	
		<script>alert('The score has been uploaded');</script>
<?php
		
	} 
	else{
?>
		<script>alert('Invalid Upload');</script>
<?php
	}
}
?>


<?php
//When the delete  button is pressed
if(isset($_POST['deleteScore'])) {
	//Retreive the score ID and remove it from the databse.
	$id = $_POST['scoreID'];
	$sql = $conn->query("DELETE FROM scores WHERE id = '$id'");
}
?>

<!DOCTYPE html>
<html lang = "en">

<!-- score_it_scoreUploadPage
Version 3 03/11/2021
by Caleb Eason /-->

  <head>
    <title>Score It - Score Management</title>

    <meta charset="utf-8"/>
    <meta name="description" content = "Musical arrangement service">
    <meta name="keyword" content ="music,arrangement,scores,request">
    <meta name="author" content = "Caleb Eason">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="style.css" rel="stylesheet" type="text/css" />

    <style>
      #container {
        width: 100%;
        height: auto;
		min-height: 800px;
        background-color: #000;
        margin: 0px;
      }
	  /* For formatting the Form */
	  .col-1 {
        width: 50%;
        height: 300px;
        float: left;
        margin: 0px;
      }
      .col-2 {
        width: 50%;
        height: 300px;
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
	  
	  /* The right link isnt used on this page, so the width needs to be increased*/
      #leftLink {
        width: 100%;
      }
	  #deleteScore {
        color: red;
		font-family: arial;
        font-size: 16px;
		text-decoration: underline;
		background-color: #000;
		margin: auto;
      }
	  #uploadScore {
        width: 150px;
        height: 45px;
        margin-top: 50px;
        color: #fff;
        font-family: arial;
        font-size: 16px;
        text-align: center;
      }
      .h4 {
        color: #FFF;
        font-family: arial;
        font-size: 32px;
        text-align: center;
        margin: 0px;
        padding-top: 84px;
      }
	  /* Table formatting */
	  .t1 {
		  color: #FFF;
		  font-family: arial;
		  font-size: 16px;
		  text-align: left;
		  margin: 0px;
		  padding: 10px 20px 10px 20px;
	   }
	   .t2 {
		  color: #FFF;
		  font-family: arial;
		  font-size: 16px;
		  text-align: left;
		  margin: 0px;
		  padding: 10px 20px 10px 20px;
	   }
	   th, td {
		   border: 2px solid white;
	   }
	  
	   /* Media Queries */
	   
	   /* When the screen is below 600px, stack the two columns on top of each other */
	   @media only screen and (max-width: 600px) {
		  .col-1 {
			  width: 100%;
			  height: 160px;
		  }
		  .col-2 {
			  width: 100%;
		  }
    </style>
  </head>
  <body>
    <div id="main"> <!--Container for the whole site/-->
	  <!-- HEADER -->
      <div id="header">
        <div id="logo"><img src="images/Logo_border.jpg" alt="logo" width="100" height="100"></div>
        <a href="index.php">
          <div id="loginButton" class="button_black">
          <p class="p3">Exit Admin</p>
          </div>
        </a>
        <div><p class="h1">Score It</p></div>
      </div>
	  <!-- NAV-BAR -->
      <div id="navBar">
        <a href="admin.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="leftLink"><p class="p3">View Requests</p></div>
        </a>
      </div>
	  <!-- CONTENT -->
      <div id="container">
		<p class="h4">Upload Score</p>
		<!-- Form for uploading scores -->
		<form name="UploadForm" method="post" action="" enctype="multipart/form-data">
            <div class="col-1"> <!-- left column -->
              <div id="subContainer1">
                <label for="title"><p class="l1">Title</p></label>
                <input type="text" id="title" class="entrybox" name="title" required="required" placeholder="Score title">
				<label for="composer"><p class="l1">Composer</p></label>
                <input type="text" id="composer" class="entrybox" name="composer" required="required" placeholder="Composer">
              </div>
            </div>
            <div class="col-2"> <!-- right column -->
              <div id="subContainer2">
                <label for="thumbnail"><p class="l1">Thumbnail</p></label>
				<input type="file" id="uploads" name="thumbnail" required="required" style="color: #fff;">
                <label for="score"><p class="l1">Score</p></label>
				<input type="file" id="uploads" name="score" required="required" style="color: #fff;">
				<input type="submit" id="uploadScore" name="uploadScore" class="button_black" value="Upload Score">
              </div>
            </div>
          </form>
		  <div>
			  <!-- Table for displaying scores -->
			  <table style="margin:auto;">
				<tr> <!-- Table header -->
					<th><p class="t1">Title</p></th>
					<th><p class="t1">Composer</p></th>
					<th><p class="t1">Thumbnail</p></th>
					<th><p class="t1">File</p></th>
					<th><p class="t1">Delete</p></th>
				</tr>
				<?php
				// Retrieve all data from the scores table
				$sql=$conn->query("select * from scores");
				
				//This while loop will create an instance of the below code for each record in the table.
				//If there are no records, nothing will happen.
				while($row=$sql->fetch_array()){
				?>
				<tr> <!-- row x.  For displaying score data -->
					<td><p class="t2"><?php echo $row['title']?></p></td>
					<td><p class="t2"><?php echo $row['composer']?></p></td>
					<td><p class="t2"><?php echo $row['thumbnail']?></p></td>
					<td><p class="t2"><?php echo $row['file']?></p></td>
					<td style="text-align: center;"> <!-- mini form for deleting a score -->
						<form name="deleteForm" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" id="scoreID" name="scoreID" value="<?php echo$row['id']?>">
							<input type="submit" id="deleteScore" name="deleteScore" value="Delete">
						</form>
					</td>
				</tr>
				<?php } ?> <!-- End of the while loop. -->
			  </table>
		  </div>
		  <!-- If there are no records in the table, display the following text --->
		  <?php if($sql->num_rows == 0) {
			echo "<br><br><br><br><p class='p3'>There are currently no scores in the database</p>";} ?>
		<br>
		<br>
		<br>
      </div>
	  <!-- FOOTER -->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>