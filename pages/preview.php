<?php 
session_start();

require_once "../eduventure.class.php";
$ev = new Eduventure();

if(isset($_POST['submit'])) {
	if(!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email'])) {
		$personal_cred = array(
			'name' => $_POST['name'],
			'phone' => $_POST['phone'],
			'email' => $_POST['email']
		);
		$_SESSION["booking_info"]["reservation"] = array_merge($_SESSION["booking_info"]["reservation"], $personal_cred);
	}
}
 ?>

  <!DOCTYPE html>
<html>
<head>
	<title>Booking</title>
	<link rel="stylesheet" type="text/css" href="../css/personal_style.css">
	<style>
		input[type=submit] {
 			width: 15%;
 		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<h2 id="title">YOUR BOOKING</h2>
			<?php 
				foreach ($_SESSION["booking_info"] as $item) :
					$total_price = 0;
					//$db->readId($item["package_cat"], "package_cat", "package");
					//if($db->rowcount == 1) {
						//$packrow = $db->result;
					//}

					//$strt_dt = date("d F Y", strtotime("$checkin"));
					//$end_dt = date("d F Y", strtotime("$checkout"));
					//echo $strt_dt . " - " . $end_dt;
					//$days = $checkin->diff($checkout);
					//$packprice = $packrow['package_price'];
					//$accoprice = $accorow['acco_price'];
					$guests = $item['guests'];
					//$total_price = ($packprice*$guests) + $accoprice;
					$days = $item['days'];
					$nights = $item['nights'];

					$checkin = strtotime($item["checkin"]);
					$checkin = date("d/m/Y", $checkin);
					$checkout = strtotime($item["checkout"]);
					$checkout = date("d/m/Y", $checkout);
			 ?>
			<p class="para">Check-in Date: <span><?php echo $checkin; ?></span></p>
			<p class="para">Check-out Date: <span><?php echo $checkout; ?></span></p>
			<p class="para">For: <span style="float:right"><?php echo $days ?> day(s)<?php if($days > 1) echo ", $nights night(s)"; ?></span></p>
			<hr>
			<p class="para">Package: <b><?php //echo $packrow['package_name']; ?></b><span style="float:right">RM<?php //echo $packprice; ?></span></p>
			<hr>
			<p class="para">Accommodation: <b><?php //echo $accorow['acco_name']; ?></b></p>
			<p class="para"><span><?php echo $item["guests"]; ?></span> Guests <span style="float:right">RM<?php //echo $accoprice; ?></span></p>
			<hr>
			<p class="para"><b>Total:</b> <span style="float:right">RM<?php //echo $total_price ?></span></p>
			<p class="para">Deposit: <span></span></p>
		</div>
		<div class="content">
				<h2 id="title-content">PERSONAL DETAILS</h2>
				<p class="para">
					<label>Name: </label>
					<span><?php echo $item["name"]; ?></span>
				</p><br>
				<p class="para">
					<label>Phone: </label>
					<span><?php echo $item["phone"]; ?></span>
				</p><br>
				<p class="para">
					<label>Email: </label>
					<span><?php echo $item["email"]; ?></span>
				</p><br>
				<p class="para"><label>Additional Requirement: </label></p>
				<textarea rows="4" cols="100" readonly></textarea>
	<?php endforeach; ?>
		<form method="post" action="confirm.php">
			<input type="submit" name="submit" value="Confirm Booking">
		</form>
		</div>
</body>
</html>
