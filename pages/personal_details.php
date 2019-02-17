<?php 
session_start();

include_once "../func.php";
require_once "../eduventure.class.php";
$ev = new Eduventure();

if(isset($_POST['submit'])) {
	if(!empty($_POST['acco_cat']) && !empty($_POST['no_acco'])) {
		$subm_acco_cat = $subm_no_acco = [];
		for ($i=0; $i < count($_POST['acco_cat']); $i++) { 
			$subm_acco_cat[] = filter_inp($_POST['acco_cat'][$i]);
			$subm_no_acco[] = filter_inp($_POST['no_acco'][$i]);
		}
		$ev->handleAccommodation($subm_acco_cat,$subm_no_acco);
	}
}

 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Booking</title>
	<link rel="stylesheet" type="text/css" href="../css/personal_style.css">
	<script>
	function verify_terms() {
    if(!$('#terms').is(':checked')) {
     alert('Please agree terms and conditions');
     return false;
    }
	}
	</script>

</head>
<body>
	<div class="container">
		<div class="header">
			<h2 id="title">YOUR BOOKING</h2>
			<?php 
				foreach ($_SESSION["booking_info"] as $item):

					$total_price = 0;

					$res_pack = $ev->listById($item["package_cat"], "package_cat", "package");
					//$rowcount_res_pack = count($res_pack);
					//if($rowcount_res_pack == 1) {
						$packrow = $res_pack;
					//}

					#---- Consider for no of guests ----#
					$packprice = $packrow['package_price'];
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
			<p class="para">For: <span style="float:right"><?php echo $days; ?> day(s)<?php if($days > 1) echo ", $nights night(s)"; ?></span></p>
			<hr>
			<p class="para">Package: <b><?php echo $packrow['package_name']; ?></b><span style="float:right">RM<?php echo $packprice; ?></span></p>
			<hr>
			<p class="para">Accommodation: <b><?php //echo $accorow['acco_name']; ?></b></p>
			<p class="para"><span><?php echo $item["guests"]; ?></span> Guests <span style="float:right">RM<?php //echo $accoprice; ?></span></p>
			<hr>
			<p class="para"><b>Total:</b> <span style="float:right">RM<?php //echo $total_price ?></span></p>
			<p class="para">Deposit: <span></span></p>
		</div>

			<?php endforeach; ?>

		<div class="content">
			<form method="post" action="preview.php" id="userdetail" onsubmit="return verify_terms();">
				<h2 id="title-content">PERSONAL DETAILS</h2>
				<p class="para">
					<label>Name: </label>
					<input type="text" name="name" class="txtbox" value="qwerty" required>
				</p><br>
				<p class="para">
					<label>Phone: </label>
					<input type="text" name="phone" class="txtbox" value="qwerty" required>
				</p><br>
				<p class="para">
					<label>Email: </label>
					<input type="text" name="email" class="txtbox" value="qwerty" required>
				</p><br>
				<p class="para"><label>Additional Requirement: </label></p>
				<textarea name="add_req" placeholder="Please state if any" rows="4" cols="100"></textarea>
				<h2 id="title-content-tnc">Terms and Conditions</h2>
				<p class="para-tnc">
					Terms: <span><input type="checkbox" id="terms"checked><strong>I have read and agree to the Booking Conditions</strong></span>
				</p>
				<input type="submit" name="submit" value="Preview">
	 			<input type="reset" value="Clear">
			</form>
		</div>

	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>	
</body>
</html>


