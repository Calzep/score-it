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
//When the deleteRequest button is pressed
if(isset($_POST['deleteRequest'])) {
    //Retreive the request ID and remove it from the databse.
	$id = $_POST['requestID'];
	$sql = $conn->query("DELETE FROM requests WHERE id = '$id'");
}
?>

<!DOCTYPE html>
<html lang = "en">

<!-- score_it_adminPage
Version 3 02/11/2021
by Caleb Eason /-->

  <head>
    <title>Score It - Request Management</title>

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
      /* The right link isnt used on this page, so the width needs to be increased*/
      #leftLink {
        width: 100%;
      }
	  #deleteRequest {
        width: 125px;
        height: 45px;
		margin: 25px 100px 0px 100px;
        padding: auto;
        color: #fff;
        font-family: arial;
        font-size: 16px;
        text-align: center;
		float: left;
      }
      .h4 {
        color: #FFF;
        font-family: arial;
        font-size: 32px;
        text-align: center;
        margin: 0px;
        padding-top: 84px;
      }
      /* text used in the table */
	  .t1 {
		  color: #FFF;
		  font-family: arial;
		  font-size: 20px;
		  text-align: left;
		  margin: 0px;
		  padding: 100px 100px 0px 100px;
	   }
	   .t2 {
		  color: #FFF;
		  font-family: arial;
		  font-size: 16px;
		  text-decoration: underline;
		  text-align: left;
		  margin: 0px;
		  padding: 25px 100px 0px 100px;
	   }
	   .t3 {
		  color: #FFF;
		  font-family: arial;
		  font-size: 16px;
		  text-align: left;
		  margin: 0px;
		  padding: 0px 100px 0px 100px;
	   }
	   .t4 {
		  color: #00ff7b;
		  font-family: arial;
		  font-size: 16px;
		  text-decoration: underline;
		  text-align: left;
		  margin: 0px;
		  padding: 25px 100px 0px 100px;
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
        <a href="admin2.php?id=<?php echo $_SESSION['UserID'];?>">
          <div id="leftLink"><p class="p3">View Scores</p></div>
        </a>
      </div>
      <!-- CONTENT -->
      <div id="container">
		<p class="h4">Score Requests</p>
        <!-- Table for displaying user requests -->
		<table style="width:100%">
            <!-- Folder path where user uploaded files are stored. --->
			<?php $folder_path = 'uploads/';?>
	
			<?php
            // Retrieve all data from the requests table
			$sql=$conn->query("select * from requests");
			
            //This while loop will create an instance of the below code for each record in the table.
            //If there are no records, nothing will happen.
			while($row=$sql->fetch_array()){
			?>
			<tr> <!-- row 1.  Displays the title and composer -->
				<th><p class="t1"> <?php echo $row['title']," - ",$row['composer'];?> </p></th>
			</tr>
			<tr> <!-- row 2 -->
				<td><p class="t2">Requesting user:</p></td>
			</tr>
			<tr> <!-- row 3 -->
				<td>
					<p class="t3">
						<?php 
                        //If the requesting user has provided a name, display it below, otherwise show "No name provided"
						if(strlen($row['first_name'])==0 && strlen($row['last_name'])==0){
							echo "No name provided";
						}
						else{
							echo $row['first_name']," ",$row['last_name'];
						}
						?>
					</p>
				</td>
			</tr>
			<tr> <!-- row 4.  Display the requesting user's email -->
				<td><p class="t3"><?php echo $row['email'];?></p></td>
			</tr>
			<tr> <!-- row 5 -->
				<td><p class="t2">Song Details</p></td>
			</tr>
			<tr> <!-- row 6. Display song data -->
				<td><p class="t3"><?php echo $row['song_data'];?></p></td>
			</tr>
			<tr> <!-- row 7 -->
				<td><p class="t2">Instrumentation Details</p></td>
			</tr>
			<tr> <!-- row 8.  Display instrument data -->
				<td><p class="t3"><?php echo $row['instrument_data'];?></p></td>
			</tr>
			<tr> <!-- row 9 -->
				<td><p class="t2">Arrangement Details</p></td>
			</tr>
			<tr> <!-- row 10.  Display arrangement data -->
				<td><p class="t3"><?php echo $row['arrangement_data'];?></p></td>
			</tr>
			<tr> <!-- row 11 -->
				<td>
					<?php
                    //If the requests has a file provided, display a button to download said file.
					if(isset($row['resources'])) {
						echo "<a href='",$folder_path,$row['resources'],"' download>";
						echo "<p class='t4'>Download Resources</p></a>";
					} ?>
				</td>
			</tr>
			<tr> <!-- row 12.  Delete request button -->
				<td>
					<form name="deleteForm" method="post" action="" enctype="multipart/form-data">
						<input type="hidden" id="requestID" name="requestID" value="<?php echo$row['id']?>">
						<input type="submit" id="deleteRequest" name="deleteRequest" class="button_black" value="Delete">
					</form>
				</td>	
			</tr>
			<?php } ?> <!-- End of the while loop. -->
		</table>
        <!-- If there are no records in the table, display the following text --->
		<?php if($sql->num_rows == 0) {
			echo "<br><br><br><br><p class='p3'>There are no current requests</p>";} ?>
		<br>
		<br>
		<br>
      </div>
      <!-- FOOTER --->
      <div id="footer"><p class="pf">Website developed by Caleb Eason</p></div>
    </div>
  </body>
</html>