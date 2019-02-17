<?php  
session_start();

include_once "../func.php";
require_once "../eduventure.class.php";
$ev = new Eduventure();

if(isset($_POST['submit'])) {
	if(!empty($_POST['guests']) && !empty($_POST['checkin'])) {
		$subm_guests = filter_inp($_POST['guests']);
		$subm_checkin = filter_inp($_POST['checkin']);
		$ev->handleDate($subm_guests,$subm_checkin);
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Booking</title>
	<link rel="stylesheet" type="text/css" href="../css/package_style.css">
</head>
<body>
	<div class="container">
		<div class="header">
			<span class="title">PACKAGE AVAILABLE</span><br>
		</div>
		<table class="table">
				<tr>
					<th>Package Name</th>
					<th>Package Price</th>
					<th>Package Period</th>
					<th>Package Description</th>
					<th></th>
				</tr>
	 <?php
	 	$result = $ev->listAll("package");
		$rowcount = count($result);
		if($rowcount > 0):
			foreach ($result as $readrow):
 		?>	
 				<form method="post" action="accommodation.php">
 					<tr>
 					<td><?php echo $readrow['package_name']; ?></td>
 					<td>RM<?php echo $readrow['package_price']; ?></td>
 					<td><?php echo $readrow['package_period']; ?> days</td>
 					<td style="font-style: italic;text-align: justify">
 						<?php if(strlen($readrow['package_desc']) > 15) {
 											$desc = $readrow['package_desc'];
									    $maxLen = 100;
									    $desc = substr($desc, 0, $maxLen);
									    echo $desc;
									} 
						 ?>
 					</td>
 					<td>
 						<input type="hidden" name="package_cat" value="<?php echo $readrow['package_cat']; ?>">
 						<input type="hidden" name="package_period" value="<?php echo $readrow['package_period']; ?>">
 						<input type="submit" name="submit" value="Choose">
 					</td>
 					</tr>
 				</form>
 	 <?php 
 			endforeach;
 		endif;
 		?>
		</table>
	</div>
</body>
</html>



