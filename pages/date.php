<?php 
session_start();
$_SESSION = [];

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Booking</title>
 	<link rel="stylesheet" type="text/css" href="../css/date_style.css">
 </head>
 <body>
 	<div class="container">
 		<h1>PLEASE ENTER THE DATES OF YOUR STAY TO CHECK AVAILABILITY</h1>
 		<form method="post" action="package.php" class="form">
 			<label>Guests</label>
 			<select name="guests" class="form-input">
 				<?php 
					for($i=1;$i<=10;$i++) {
						echo "<option value=" . $i . ">" . $i . "</option>";
					}
 				 ?>
 			</select>
 			<label>Check-in Date</label>
 			<input type="date" name="checkin" class="form-input" required>

		<div style="margin-left:50px">
			<input type="submit" name="submit">
 			<input type="reset" value="Clear">
		</div>
 		</form>
 	</div>
 </body>
 </html>
