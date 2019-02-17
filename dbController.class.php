<?php 

class DBController {
  private $host = "localhost";
  private $db_name = "eduventureprj";
  private $username = "root";
  private $password = "123456";
  private $conn;
  public $rowcount;
  public $result;

  // private
  public function connect() {
	  $this->conn = null;
    $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  // private
  public function disconnect() {
    $this->conn = null;
  }

  public function create_booking_cred($name, $phone, $email, $guests, $checkin, $checkout, $days, $nights, $reservation_id) {
    try {
      $sql = "INSERT INTO booking_cred (id, name, phone, email, guests, checkin, checkout, days, nights, reservation_id) VALUES (NULL, :name, :phone, :email, :guests, :checkin, :checkout, :days, :nights, :reservation_id)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':guests', $guests, PDO::PARAM_INT);
      $stmt->bindParam(':checkin', $checkin);
      $stmt->bindParam(':checkout', $checkout);
      $stmt->bindParam(':days', $days, PDO::PARAM_INT);
      $stmt->bindParam(':nights', $nights, PDO::PARAM_INT);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function create_booking_status($reservation_id, $booking_status) {
    try {
      $sql = "INSERT INTO booking_status (reservation_id, booking_status, booking_timestamp) VALUES (:reservation_id, :booking_status, NULL)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $stmt->bindParam(':booking_status', $booking_status, PDO::PARAM_STR);
      $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function create_package_booking($package_list_id, $package_cat, $checkin, $checkout, $reservation_id) {
    try {
      $sql = "INSERT INTO package_booking (package_list_id, package_cat, checkin, checkout, reservation_id) VALUES (:package_list_id, :package_cat, :checkin, :checkout, :reservation_id)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':package_list_id', $package_list_id, PDO::PARAM_STR);
      $stmt->bindParam(':package_cat', $package_cat, PDO::PARAM_STR);
      $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
      $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function create_acco_booking($acco_list_id, $acco_cat, $checkin, $checkout, $reservation_id) {
    try {
      $sql = "INSERT INTO acco_booking (acco_list_id, acco_cat, checkin, checkout, reservation_id) VALUES (:acco_list_id, :acco_cat, :checkin, :checkout, :reservation_id)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':acco_list_id', $acco_list_id, PDO::PARAM_STR);
      $stmt->bindParam(':acco_cat', $acco_cat, PDO::PARAM_STR);
      $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
      $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function update_booking_status($reservation_id, $booking_status) {
    try {
      $sql = "UPDATE booking_status SET booking_status = :booking_status WHERE reservation_id = :reservation_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':booking_status', $booking_status, PDO::PARAM_STR);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function update_acco_avail_count($acco_cat, $acco_avail) {
    try {
      $this->connect();
      $sql = "UPDATE accommodation SET acco_avail = :acco_avail WHERE acco_cat = :acco_cat";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':acco_cat', $acco_cat, PDO::PARAM_STR);
      $stmt->bindParam(':acco_avail', $acco_avail, PDO::PARAM_STR);
      $stmt->execute();
      $this->disconnect();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function readAll($tbl) {
    try {
      $this->connect();
      $sql = "SELECT * FROM $tbl";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->disconnect();
      return $result;
    } catch(PDOException $e) {
        $this->disconnect();
        echo "Error: " . $e->getMessage();
    }
  }

  public function read_booking_status() {
    try {
      $sql = "SELECT * FROM booking_cred, booking_status WHERE ";
      $sql .= "booking_cred.reservation_id = booking_status.reservation_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $rowcount = $stmt->rowcount();
      $result = $stmt->fetchAll();
      $this->rowcount = $rowcount;
      $this->result = $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function read_booking_list_ajax() {
    try {
      $sql = "SELECT * FROM booking_cred, booking_status WHERE ";
      $sql .= "booking_cred.reservation_id = booking_status.reservation_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $rowcount = $stmt->rowcount();
      $result = $stmt->fetchAll();
      $this->rowcount = $rowcount;
      $this->result = $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function readId($id, $id_name, $tbl) {
    try {
      $this->connect();
      $sql = "SELECT * FROM $tbl WHERE $id_name = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->disconnect();
      return $result;
    } catch(PDOException $e) {
      $this->disconnect();
      echo "Error: " . $e->getMessage();
    }
  }

  public function readStatCredId($id) {
    try {
      $sql = "SELECT * FROM booking_cred, booking_status WHERE booking_cred.reservation_id = :id AND booking_status.reservation_id = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      $rowcount = $stmt->rowcount();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->rowcount = $rowcount;
      $this->result = $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function read_package_avail($package_cat, $checkin, $checkout) {
    try {
      $this->connect();
      $sql = "SELECT package_list_id FROM package_list WHERE package_cat = :package_cat AND package_list_id NOT IN (SELECT package_list_id FROM package_booking WHERE package_cat = :package_cat AND :checkin < checkout AND :checkout > checkin)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':package_cat', $package_cat, PDO::PARAM_STR);
      $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
      $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->disconnect();
      return $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function read_package_avail_count($package_cat, $checkin, $checkout) {
    try {
      $this->connect();
      $sql = "SELECT COUNT(package_list_id) AS count_package_list_avail FROM package_list WHERE package_cat = :package_cat AND package_list_id NOT IN (SELECT package_list_id FROM package_booking WHERE package_cat = :package_cat AND :checkin < checkout AND :checkout > checkin)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':acco_cat', $acco_cat, PDO::PARAM_STR);
      $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
      $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->disconnect();
      return $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function read_acco_avail($acco_cat, $checkin, $checkout) {
    try {
      $this->connect();
      $sql = "SELECT acco_list_id FROM acco_list WHERE acco_cat = :acco_cat AND acco_list_id NOT IN (SELECT acco_list_id FROM acco_booking WHERE acco_cat = :acco_cat AND :checkin < checkout AND :checkout > checkin)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':acco_cat', $acco_cat, PDO::PARAM_STR);
      $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
      $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->disconnect();
      return $result;
    } catch(PDOException $e) {
      $this->disconnect();
      echo "Error: " . $e->getMessage();
    }
  }

  public function read_acco_avail_count($acco_cat, $checkin, $checkout) {
    try {
      $this->connect();
      $sql = "SELECT COUNT(acco_list_id) AS count_acco_list_avail FROM acco_list WHERE acco_cat = :acco_cat AND acco_list_id NOT IN (SELECT acco_list_id FROM acco_booking WHERE acco_cat = :acco_cat AND :checkin < checkout AND :checkout > checkin)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':acco_cat', $acco_cat, PDO::PARAM_STR);
      $stmt->bindParam(':checkin', $checkin, PDO::PARAM_STR);
      $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->disconnect();
      return $result;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function delete($reservation_id) {
    try {
      $sql = "DELETE FROM booking_status WHERE reservation_id = :reservation_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  public function delete_booking_row($reservation_id) {
    try {
      $sql = "DELETE booking_status, booking_cred, acco_booking, package_booking
              FROM booking_status
              INNER JOIN booking_cred ON booking_cred.reservation_id = booking_status.reservation_id
              INNER JOIN acco_booking ON acco_booking.reservation_id = booking_status.reservation_id
              INNER JOIN package_booking ON package_booking.reservation_id = booking_status.reservation_id
              WHERE booking_status.reservation_id = :reservation_id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':reservation_id', $reservation_id, PDO::PARAM_STR);
      $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
}

 ?>
