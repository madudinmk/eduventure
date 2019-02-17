<?php 
require "dbController.class.php";

Class Eduventure {
	private $db;
	public static $package_cat;
	public static $days;
	public static $nights;
	public static $checkin;
	public static $checkout;
	public static $checkin_clean;
	public static $checkout_clean;
	public static $guests;
	

	public function __construct() {
    $this->db = new DBController();
  }

	public function handleDate($subm_guests,$subm_checkin) {

				$guests = $subm_guests;
				$checkin_avail = $subm_checkin;
				$_SESSION["booking_info"] = array(
					'reservation' => array(
						'guests' => $guests,
						'checkin' => $checkin_avail
					)
				);
	}

	public function handlePackage($subm_package_cat,$subm_package_period) {
			$package_cat = $subm_package_cat;
			$days = $subm_package_period;
			$checkin = $_SESSION["booking_info"]["reservation"]["checkin"];
			
			switch ($days) {
				case '1':
					$nights = '0';
					$checkout = date("Y-m-d", strtotime($checkin."+".$nights." days"));
					break;
				case '2':
					$nights = '1';
					$checkout = date("Y-m-d", strtotime($checkin."+".$nights." days"));
					break;
				case '4':
					$nights = '3';
					$checkout = date("Y-m-d", strtotime($checkin."+".$nights." days"));
					break;
			}

		#---- Experimenting with reading PACKAGE AVAILABILITY ----#

			$result = $this->db->read_package_avail($package_cat, $checkin, $checkout);
			$rowcount = count($result);
			//echo "\$rowcount: ".$rowcount."<br>";
			if($rowcount > 0) {
				$package_list_id_r = [];
				//echo "<table>";
				foreach ($result as $pavailrow):
		#---- TABLE FOR DEBUGGING PURPOSE ----#	
					//echo "<tr>";
					//echo "<td>".$pavailrow['package_list_id']."</td>";
					//echo "<tr>";
		#---- TABLE FOR DEBUGGING PURPOSE ----#
					array_push($package_list_id_r, $pavailrow['package_list_id']); 
				endforeach;
				//echo "</table>";

				$package_arr = array(
						'checkout' => $checkout,
						'days' => $days,
						'nights' => $nights,
						'package_cat' => $package_cat,
						'package_list_id' => $package_list_id_r[0]
				);
			$_SESSION["booking_info"]["reservation"] = array_merge($_SESSION["booking_info"]["reservation"], $package_arr);
			} else {
				#--- Redirect if there's no package available ---#
				header("Location:package.php");
			}

		$checkin = $_SESSION["booking_info"]["reservation"]["checkin"];
		$checkout = $_SESSION["booking_info"]["reservation"]["checkout"];

		$ac_avail_count = $this->db->read_acco_avail_count("AC", $checkin, $checkout);
		$ac_rowcount = count($ac_avail_count);
			if($ac_rowcount == 1):
				$ac_data = $ac_avail_count; 
				$AC_count = $ac_data['count_acco_list_avail'];
				$this->db->update_acco_avail_count("AC", $AC_count);
			endif;
		$ah_avail_count = $this->db->read_acco_avail_count("AH", $checkin, $checkout);
		$ah_rowcount = count($ah_avail_count);
			if($ah_rowcount == 1):
				$ah_data = $ah_avail_count; 
				$AH_count = $ah_data['count_acco_list_avail'];
				$this->db->update_acco_avail_count("AH", $AH_count);
			endif;
		$as_avail_count = $this->db->read_acco_avail_count("AS", $checkin, $checkout);
		$as_rowcount = count($as_avail_count);
			if($as_rowcount == 1):
				$as_data = $as_avail_count; 
				$AS_count = $as_data['count_acco_list_avail'];
				$this->db->update_acco_avail_count("AS", $AS_count);
			endif;

		$checkin_clean = strtotime($checkin);
		$checkin_clean = date("l, F jS, Y", $checkin_clean);
		$checkout_clean = strtotime($checkout);
		$checkout_clean = date("l, F jS, Y", $checkout_clean);

		self::$package_cat = $_SESSION['booking_info']['reservation']['package_cat'];
		self::$days = $_SESSION['booking_info']['reservation']['days'];
		self::$nights = $_SESSION['booking_info']['reservation']['nights'];
		self::$checkin = $checkin;
		self::$checkout = $checkout;
		self::$checkin_clean = $checkin_clean;
		self::$checkout_clean = $checkout_clean;
		self::$guests = $_SESSION["booking_info"]["reservation"]["guests"];

		if(self::$guests < 5) {
			$no_acco = 1;
		} else if(self::$guests < 9) {
			$no_acco = 2;
		} else {
			$no_acco = 3;
		}
	}

	public function handleAccommodation($subm_acco_cat,$subm_no_acco) {

		$acco_cat_r = $subm_acco_cat;
		$no_acco_r = $subm_no_acco;
		$acco_cat_chosen = array_combine($acco_cat_r, $no_acco_r);
		$acco_cat_chosen = array_filter($acco_cat_chosen, function($number) {
			return $number > 0;
		}, ARRAY_FILTER_USE_BOTH);
		$acco_cat_chosen_keys = array_keys($acco_cat_chosen);
		$acco_cat_chosen_values = array_values($acco_cat_chosen);
		$acco_cat_chosen_count = count($acco_cat_chosen);

		$checkin = $_SESSION["booking_info"]["reservation"]["checkin"];
		$checkout = $_SESSION["booking_info"]["reservation"]["checkout"];
		$guests = $_SESSION["booking_info"]["reservation"]["guests"];

		#--- START ---#
		if(count($acco_cat_chosen) == 1) {
			//$db->read_acco_avail($acco_cat, $checkin, $checkout);
			//echo "<br><b>start here: if</b>";
			$result_one = $this->db->read_acco_avail($acco_cat_chosen_keys[0], $checkin, $checkout);
			$rowcount_one = count($result_one);
			if($rowcount_one > 0) {
				$acco_list_id_r = [];
				//echo "<table style=float:right>";
				foreach ($result_one as $aavailrow) {
		#---- TABLE FOR DEBUGGING PURPOSE ----#	
					//echo "<tr>";
					//echo "<td>".$aavailrow['acco_list_id']."</td>";
					//echo "<tr>";
		#---- TABLE FOR DEBUGGING PURPOSE ----#
					array_push($acco_list_id_r, $aavailrow['acco_list_id']);
				}
			}
				//echo "</table>";

			if($acco_cat_chosen_values[0] > 1) {
				$for_count = $acco_cat_chosen_values[0];
				$acco_list_id_chosen_r = [];
				$arr_temp = [];
				$acco_list_id_session = [];
				for ($i=0;$i<$for_count;$i++) {
					$acco_list_id_chosen_r[$i] = $acco_list_id_r[$i];
					$arr_temp = array(
						'acco_list_id_'.$i => $acco_list_id_chosen_r[$i]
					);
					$acco_list_id_session = array_merge($acco_list_id_session, $arr_temp);
				}
				$acco_list_id_session = array_merge($acco_list_id_session, $acco_cat_chosen);
			} else {
				$acco_list_id_chosen_r[0] = $acco_list_id_r[0];
				$acco_list_id_session = array(
						'acco_list_id_0' => $acco_list_id_chosen_r[0]
				);
				$acco_list_id_session = array_merge($acco_list_id_session, $acco_cat_chosen);
			}
				
		} else { //For more than one type of accommodation
			$acco_list_id_session = [];
			//echo "<br><b>start here: else</b>";
			for($i=0;$i<$acco_cat_chosen_count;$i++) {
				$result_many = $this->db->read_acco_avail($acco_cat_chosen_keys[$i], $checkin, $checkout);
				$rowcount_many = count($result_many);
				if($rowcount_many > 0) {
					$acco_list_id_r = [];
					//echo "<table style=float:right>";
					foreach ($result_many as $aavailrow) {
			#---- TABLE FOR DEBUGGING PURPOSE ----#	
						//echo "<tr>";
						//echo "<td>".$aavailrow['acco_list_id']."</td>";
						//echo "<tr>";
			#---- TABLE FOR DEBUGGING PURPOSE ----#
						array_push($acco_list_id_r, $aavailrow['acco_list_id']);
					}
				}
				//echo "</table>";
			
			#####################################

				if($acco_cat_chosen_values[$i] > 1) {
				$for_count = $acco_cat_chosen_values[$i];
				$acco_list_id_chosen_r_repeat = [];
				//$arr_temp = [];

				// $k = isset($acco_list_id_session) ? 1 : 2;
					for ($j=0;$j<$for_count;$j++) { 
						$arr_temp = [];
						$acco_list_id_chosen_r_repeat[$j] = $acco_list_id_r[$j];

						if(isset($acco_list_id_session)) {
							$a = count($acco_list_id_session);

							$arr_temp = array(
								'acco_list_id_'.$a => $acco_list_id_chosen_r_repeat[$j]
							);
						} else {
							echo "<br>\$j: ".$j;
							$arr_temp = array(
								'acco_list_id_'.$j => $acco_list_id_chosen_r_repeat[$j]
							);
						}

						$acco_list_id_session = array_merge($acco_list_id_session, $arr_temp);

					
					}

				} else {
					$acco_list_id_chosen_r = [];
					
					$acco_list_id_chosen_r[0] = $acco_list_id_r[0];

					if(isset($acco_list_id_session)) {
						$a = count($acco_list_id_session);
						$arr_temp = array(
								'acco_list_id_'.$a => $acco_list_id_chosen_r[0]
						);
					} else {
						$arr_temp = array(
								'acco_list_id_'.$i => $acco_list_id_chosen_r[0]
						);
					}

					$acco_list_id_session = array_merge($acco_list_id_session, $arr_temp);

				}

			} /* For */ 
			$acco_list_id_session = array_merge($acco_list_id_session, $acco_cat_chosen);

			//echo "<br><b>FINALE: \$acco_list_id_session: ";
			//print_r($acco_list_id_session);
			//echo "</b>";

		} /* Else */

			$_SESSION["booking_info"]["reservation"] = array_merge($_SESSION["booking_info"]["reservation"], $acco_list_id_session);

	} # handleAccommodation #

	public function listAll($tbl) {
		$result = $this->db->readAll($tbl);
		return $result;
	}

	public function listById($id, $id_name, $tbl) {
		$result = $this->db->readId($id, $id_name, $tbl);
		return $result;
	}





} # Class #



 ?>