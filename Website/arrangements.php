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

<!-- score_it_arrangementsPage
Version 2 03/11/2021
by Caleb Eason /-->

  <head>
    <title>Score It - Arrangements</title>

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
		min-height: 600px;
        background-color: #000;
        margin: 0px;
      }
      #image {
        background-image: url("images/home_1.jpg");
        height: 200px;
        background-position: fixed -100px;
        background-repeat: no-repeat;
        background-size:  cover;
      }
	  .thumbnail {
		width: 150px;
		height: auto;
		float: right;
		margin-right: 20px;
		padding: auto;
		border: 2px solid #FFF;
	  }
      .h4 {
        color: #FFF;
        font-family: arial;
        font-size: 32px;
        text-align: center;
        margin: 0px;
        padding-top: 84px;
      }
      /*Defines the width of the table columns*/
	  .leftCell {
		width: 33%;
	  }
	  .rightCell {
		width: 67%;
	  } 
      /*Text used in the table*/
	  .t1 {
		  color: #FFF;
		  font-family: arial;
		  font-size: 20px;
		  text-align: left;
		  margin: 0px;
		  padding: 0px;
	   }
	   .t2 {
		  color: #FFF;
		  font-family: arial;
		  font-size: 16px;
		  text-align: left;
		  margin: 0px;
	   }
       /* Border used for testing*/
	   /*table, th, td {
		   border:2px solid white;
	   }*/
        
	   /* Media Queries */
        
       /* Changes the width of the table columns to be equal below 800px,
        prevents overcrowding on smaller screens*/
       @media only screen and (max-width: 800px) {
		  .leftCell {
			  width: 50%;
	    }
		   .rightCell {
			  width: 50%;
	    }
    </style>
      
  </head>
  <body>
    <div id="main"> <!--Container for the whole site/-->
      <!-- HEADER --->
      <div id="header">
        <div id="logo"><img src="images/Logo_border.jpg" alt="logo" width="100" height="100"></div>
        <a href="account.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="loginButton" class="button_green">
          <p class="p1">My Account</p>
          </div>
        </a>
        <div><p class="h1">Score It</p></div>
      </div>
      <!-- NAV-BAR --->
      <div id="navBar">
        <a href="arrangements.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="leftLink"><p class="p3">Browse</p></div>
        </a>
        <a href="requests.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="rightLink"><p class="p3">Request</p></div>
        </a>
      </div>
      <!-- CONTENT --->
      <div id="image">
          <p class="h4">Arrangements</p>
      </div>
      <div id="container">
	  <br>
	  <br>
	  <br>
	  <br>
        <!-- Table for displaying scores --> 
		<table style="width:100%;">
            <!-- Folder path where scores are stored. --->
			<?php $folder_path = 'scores/';?>
			
			<?php
            //retrives all data from the scores table
			$sql=$conn->query("select * from scores");
            
			//This while loop will create an instance of the below code for each record in the table.
            //If there are no records, nothing will happen.
			while($row=$sql->fetch_array()){
			?>
				<tr> <!-- Row 1.  Contains the scores thumbnail (with rowspan of 3) and title--->
					<td class="leftCell" rowspan="3">
                        <img class="thumbnail" src="<?php echo $folder_path,$row['thumbnail'];?>" alt="score thumbnail">
                    </td>
					<th class="rightCell"><p class="t1"><?php echo $row['title'];?></p></th>
				</tr>
				<tr> <!-- Row 2.  Contains the score's composer --->
					<td><p class="t2"><?php echo $row['composer'];?></p></td>
				</tr>
				<tr> <!-- Row 3.  Provides blank space for formatting --->
					<td>
						<br>
						<br>
						<br>
						<br>
					</td>
				</tr>
				<tr> <!-- Row 4.  Contains the download button --->
					<td>
						<a href="<?php echo $folder_path,$row['file'];?>" download>
							<div id="loginButton" class="button_black" style="margin-top:15px;">
								<p class="p3">Download</p>
							</div>
						</a>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
					</td>
				</tr>
				<?php } ?> <!-- end of the while loop --->
		</table>
        <!-- If there are no records in the table, display the following text --->
		<?php if($sql->num_rows == 0) {
			echo "<br><br><br><br><p class='p3'>There are currently no arrangements in the database</p>";} ?>
		<br>
		<br>
		<br>
      </div>
      <!-- FOOTER --->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>