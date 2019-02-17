<?php 

//require_once "dbController.class.php";
require_once "dbConfig.class.php";

$params = $_REQUEST;
$action = isset($params['action']) && $params['action'] != '' ? $params['action'] : 'lists';
$admin = new Admin();

switch($action) {
	case 'lists':
		$admin->read_booking_list_ajax();
		break;
	case 'list':
		$id = isset($params['id']) && $params['id'] != '' ? $params['id'] : '';
		$admin->read_stat_cred_id($id);
		break;
	case 'delete':
		$id = isset($params['id']) && $params['id'] != '' ? $params['id'] : '';
		$admin->delete_data($id);
		break;
  case 'status':
    $id = isset($params['id']) && $params['id'] != '' ? $params['id'] : '';
    $status = isset($params['stat']) && $params['stat'] != '' ? $params['stat'] : '';
    $admin->update_booking_status($id,$status);
    break;
}

$admin->disconnect();



/* ADMIN CLASS */

class Admin {
  private $conn;
  //private $data = array();

  public function __construct() {
		//$db = new dbController();
    $db = new dbConfig();
    $this->conn = $db->connect();
  }

  public function disconnect() {
  	$this->conn = null;
  }
  
  public function update_booking_status($reservation_id, $booking_status) {
    try {
      $sql = "UPDATE booking_status SET booking_status = :booking_status WHERE reservation_id = :reservation_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':booking_status', $booking_status, PDO::PARAM_STR);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $queryUpdate = $stmt->execute();
      if($queryUpdate) {
        echo true;
      } else {
        echo false;
      }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function delete_data($reservation_id) {
  	try {
      $sql = "DELETE booking_status, booking_cred, acco_booking, package_booking
              FROM booking_status
              INNER JOIN booking_cred ON booking_cred.reservation_id = booking_status.reservation_id
              INNER JOIN acco_booking ON acco_booking.reservation_id = booking_status.reservation_id
              INNER JOIN package_booking ON package_booking.reservation_id = booking_status.reservation_id
              WHERE booking_status.reservation_id = :reservation_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $queryDelete = $stmt->execute();
      if($queryDelete) {
      	echo true;
      } else {
      	echo false;
      }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function read_booking_list_ajax() {
    try {
      $sql = "SELECT * FROM booking_cred, booking_status WHERE ";
      $sql .= "booking_cred.reservation_id = booking_status.reservation_id";
      //$sql .= "ORDER BY booking_cred.id DESC";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      //$rowcount = $stmt->rowcount();
      $result = $stmt->fetchAll();
      echo json_encode($result);
      //$this->rowcount = $rowcount;
      //$this->result = $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function read_stat_cred_id($id) {
    try {
      $sql = "SELECT * FROM booking_cred, booking_status WHERE booking_cred.reservation_id = :id AND booking_status.reservation_id = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      //$rowcount = $stmt->rowcount();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      echo json_encode($result);
      //$this->rowcount = $rowcount;
      //$this->result = $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }


}

 ?>