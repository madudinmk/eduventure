<?php 
session_start();

include_once "../func.php";
require_once "../eduventure.class.php";
$ev = new Eduventure();

if(isset($_POST['submit'])) {
	if(!empty($_POST['package_cat']) && !empty($_POST['package_period'])) {
		$subm_package_cat = filter_inp($_POST['package_cat']);
		$subm_package_period = filter_inp($_POST['package_period']);
		$ev->handlePackage($subm_package_cat,$subm_package_period);
	}
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Booking</title>
	<link rel="stylesheet" type="text/css" href="../css/accommodation_style.css">
</head>
<body>
	<div class="container">
		<div class="header">
			<span class="title">AVAILABLE ACCOMMODATION FROM</span><br>
			<span><?php echo Eduventure::$checkin_clean . " to " . Eduventure::$checkout_clean; ?></span><span style="float:right;font-weight: bold"><?php echo Eduventure::$guests; ?> Guests</span>
		</div>
		<table class="table">
				<tr>
					<th>Accommodation Type</th>
					<th>Accommodation Price</th>
					<th>Accommodation Size</th>
					<th>Accommodation Availability</th>
					<th>Accommodation Description</th>
					<th></th>
				</tr>
	 <?php
		$result = $ev->listAll("accommodation");
		$rowcount = count($result);
		if($rowcount > 0):
			foreach ($result as $readrow):
 		?>
 				
 					<tr>
 					<td><?php echo $readrow['acco_name']; ?></td>
 					<td>RM<?php echo $readrow['acco_price']; ?></td>
 					<td><?php echo $readrow['acco_size_guests']; ?> guests</td>
 					<td><?php echo $readrow['acco_avail']; ?> sites/rooms</td>
 					<td style="font-style: italic;text-align: justify">
 						<?php if (strlen($readrow['acco_desc']) > 15) {
 											$desc = $readrow['acco_desc'];
									    $maxLen = 80;
									    $desc = substr($desc, 0, $maxLen);
									    echo $desc;
									} 
						 ?>
 					</td>
 					<td>
					<form method="post" action="personal_details.php" id="acco-pg-form">

						<input type="hidden" name="acco_cat[]" value="<?php echo $readrow['acco_cat']; ?>">

								<input type="number" name="no_acco[]" value="0" min="0" max="<?php echo $readrow['acco_avail']; ?>" <?php if($readrow['acco_avail'] == 0) echo "readonly"; ?>>
 					</td>
 				</tr>
 	 <?php 
 			endforeach;
 		endif;
 		?>
		</table>
			<input type="submit" name="submit" value="Continue" id="inp-out-tbl">
		</form>
		<button onclick="return check_acco();">Check</button>
		<p id="demo1"></p>
		<p id="demo2"></p>
	</div>
	<script type="text/javascript" src="js/forms.js"></script>
</body>
</html>

