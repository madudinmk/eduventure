<?php 
session_start();

include_once "../func.php";
require_once "../dbController.class.php";
$db = new dbController();
$db->connect();

if(isset($_POST['submit'])) {
	foreach($_SESSION["booking_info"]["reservation"] as $key => $value) {
		switch ($key) {
			case 'AC':
				if($value > 1) {
					for ($i=0; $i < $value; $i++) {
						//echo "<br>".$key;
						$acco_cat_r[] = filter_inp($key);
					}
				} else {
					//echo "<br>".$key;
					$acco_cat_r[] = filter_inp($key);
				}
				break;
			case 'AH':
				if($value > 1) {
					for ($i=0; $i < $value; $i++) {
						//echo "<br>".$key;
						$acco_cat_r[] = filter_inp($key);
					}
				} else {
					//echo "<br>".$key;
					$acco_cat_r[] = filter_inp($key);
				}
				break;
			case 'AS':
				if($value > 1) {
					for ($i=0; $i < $value; $i++) {
						//echo "<br>".$key;
						$acco_cat_r[] = filter_inp($key);
					}
				} else {
					//echo "<br>".$key;
					$acco_cat_r[] = filter_inp($key);
				}
				break;
		}
	}

	foreach($_SESSION["booking_info"]["reservation"] as $key => $value) {	
		for ($i=0; $i<count($acco_cat_r); $i++) { 
			switch ($key) {
			case 'acco_list_id_'.$i:
				//echo "<br>".$key;
				$acco_list_id_r[] = filter_inp($value);
				break;
			} 			
		}
	}

	$reservation_id = "EDU" . uniqid();
	$reservation_id = filter_inp($reservation_id);
	foreach ($_SESSION["booking_info"] as $item):
		$name = filter_inp($item["name"]);
		$phone = filter_inp($item["phone"]);
		$email = filter_inp($item["email"]);
		$guests = filter_inp($item["guests"]);
		$package_cat = filter_inp($item["package_cat"]);
		$package_list_id = filter_inp($item["package_list_id"]);
		$checkin = filter_inp($item["checkin"]);
		$checkout = filter_inp($item["checkout"]);
		$days = filter_inp($item["days"]);
		$nights = filter_inp($item["nights"]);
	endforeach;

	$start_time = (float) microtime(true);

	$db->create_booking_cred($name, $phone, $email, $guests, $checkin, $checkout, $days, $nights, $reservation_id);
	$db->create_booking_status($reservation_id, "Pending");
	$db->create_package_booking($package_list_id, $package_cat, $checkin, $checkout, $reservation_id);

	for ($i=0;$i<count($acco_cat_r);$i++) { 
		$db->create_acco_booking($acco_list_id_r[$i], $acco_cat_r[$i], $checkin, $checkout, $reservation_id);
	}

	$end_time = (float) microtime(true);
	$time_taken = $end_time - $start_time;
	echo "<br><b>Successfully create records.</b>";
	echo "<br><b>Time taken: ".$time_taken." sec</b>";

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Eduventure: Booking Confirmation</title>
	<link rel="stylesheet" type="text/css" href="../css/confirm_style.css">
</head>
<body>
	<div class="container">
		<p>Your reservation has been successfully sent to the administrator.</p>
		<p>Your reservation ID is <?php echo $reservation_id; ?>.</p>
		<p>If you have any questions, please contact us.</p>
		<br>
		<a href="date.php" class="btn">Start a new reservation</a>
	</div>
	<?php $db->disconnect(); ?>
</body>
</html>

<?php echo "<br>\$_SESSION['booking_info']: <br>"?>
<?php print_r($_SESSION['booking_info']); ?>
