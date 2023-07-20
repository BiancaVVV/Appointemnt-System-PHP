<?php

class client {

	private $clientTable = 'hms_clients';
	private $conn;

	public function __construct($db){
        $this->conn = $db;
    }

	public function listclients(){

		$sqlWhere = '';
		if($_SESSION["role"] == 'client') {
			$sqlWhere = "WHERE id = '".$_SESSION["userid"]."'";
		}
		$sqlQuery = "SELECT * FROM ".$this->clientTable." $sqlWhere";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' AND (name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR email LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR gender LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR mobile LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR address LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR age LIKE "%'.$_POST["search"]["value"].'%") ';
		}

		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}

		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();

		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->clientTable." $sqlWhere");
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;

		$displayRecords = $result->num_rows;
		$records = array();
		while ($client = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $client['id'];
			$rows[] = ucfirst($client['name']);
			$rows[] = $client['gender'];
			$rows[] = $client['age'];
			$rows[] = $client['email'];
			$rows[] = $client['mobile'];
			$rows[] = $client['address'];
			$rows[] = $client['medical_history'];
			$rows[] = '<button type="button" name="view" id="'.$client["id"].'" class="btn btn-info btn-xs view"><span class="glyphicon glyphicon-file" title="View">View</span></button>';
			$rows[] = '<button type="button" name="update" id="'.$client["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			if($_SESSION["role"] != 'client') {
				$rows[] = '<button type="button" name="delete" id="'.$client["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
			} else {
				$rows[] = '';
			}
			$records[] = $rows;
		}

		$output = array(
			"draw"	=>	intval($_POST["draw"]),
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);

		echo json_encode($output);
	}

	public function insert(){

		if($this->name) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->clientTable."(`name`, `email`, `gender`, `mobile`, `address`,`age`,`medical_history`)
			VALUES(?,?,?,?,?,?,?)");

			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->gender = htmlspecialchars(strip_tags($this->gender));
			$this->mobile = htmlspecialchars(strip_tags($this->mobile));
			$this->address = htmlspecialchars(strip_tags($this->address));
			$this->age = htmlspecialchars(strip_tags($this->age));
			$this->medical_history = htmlspecialchars(strip_tags($this->medical_history));

			$stmt->bind_param("sssssis", $this->name, $this->email, $this->gender, $this->mobile, $this->address, $this->age, $this->medical_history);

			if($stmt->execute()){
				return true;
			}
		}
	}

	public function update(){

		if($this->id) {

			$stmt = $this->conn->prepare("
			UPDATE ".$this->clientTable."
			SET name= ?, email = ?, gender = ?, mobile = ?, address = ?, age = ?, medical_history = ?
			WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->gender = htmlspecialchars(strip_tags($this->gender));
			$this->mobile = htmlspecialchars(strip_tags($this->mobile));
			$this->address = htmlspecialchars(strip_tags($this->address));
			$this->age = htmlspecialchars(strip_tags($this->age));
			$this->medical_history = htmlspecialchars(strip_tags($this->medical_history));

			$stmt->bind_param("sssssisi", $this->name, $this->email, $this->gender, $this->mobile, $this->address, $this->age, $this->medical_history, $this->id);

			if($stmt->execute()){
				return true;
			}

		}
	}

	public function getclient(){
		if($this->id) {
			$sqlQuery = "
				SELECT * FROM ".$this->clientTable."
				WHERE id = ?";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}

	public function delete(){
		if($this->id) {

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->clientTable."
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	}

	public function getTotalclient(){
		$stmt = $this->conn->prepare("
		SELECT *
		FROM ".$this->clientTable);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows;
	}

	function clientList(){
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->clientTable);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}
}
?>
