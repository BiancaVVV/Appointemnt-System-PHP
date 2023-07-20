<?php

class consultant {

	private $consultantTable = 'hms_consultant';
	private $specializationTable = 'hms_specialization';
	private $conn;

	public function __construct($db){
        $this->conn = $db;
    }

	public function listconsultants(){

		$sqlWhere = '';
		if($_SESSION["role"] == 'consultant') { 
			$sqlWhere = " WHERE consultant.id = '".$_SESSION["userid"]."'";
		}

		$sqlQuery = "SELECT consultant.id, consultant.name, consultant.address, consultant.mobile, consultant.fee, specialization.specialization
		FROM ".$this->consultantTable." consultant
		LEFT JOIN ".$this->specializationTable." specialization ON specialization.id = consultant.specialization
		$sqlWhere ";

		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' AND (consultant.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR consultant.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR consultant.mobile LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR consultant.address LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR consultant.fee LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR consultant.specialization LIKE "%'.$_POST["search"]["value"].'%") ';
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

		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->consultantTable." $sqlWhere " );
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;

		$displayRecords = $result->num_rows;
		$records = array();
		while ($consultant = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $consultant['id'];
			$rows[] = ucfirst($consultant['name']);
			$rows[] = $consultant['address'];
			$rows[] = $consultant['mobile'];
			$rows[] = $consultant['fee'];
			$rows[] = $consultant['specialization'];
			$rows[] = '<button type="button" name="view" id="'.$consultant["id"].'" class="btn btn-info btn-xs view"><span class="glyphicon glyphicon-file" title="View">View</span></button>';
			$rows[] = '<button type="button" name="update" id="'.$consultant["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$consultant["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
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

	public function getconsultant(){
		if($this->id) {

			$sqlQuery = "SELECT consultant.id, consultant.name, consultant.address, consultant.mobile, consultant.fee, specialization.id AS specialization_id
			FROM ".$this->consultantTable." consultant
			LEFT JOIN ".$this->specializationTable." specialization ON specialization.id = consultant.specialization
			WHERE consultant.id = ?";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}

	public function insert(){

		if($this->name) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->consultantTable."(`name`, `email`, `mobile`, `address`, `fee`,`specialization`)
			VALUES(?,?,?,?,?,?)");

			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->mobile = htmlspecialchars(strip_tags($this->mobile));
			$this->address = htmlspecialchars(strip_tags($this->address));
			$this->fee = htmlspecialchars(strip_tags($this->fee));
			$this->specialization = htmlspecialchars(strip_tags($this->specialization));

			$stmt->bind_param("ssssis", $this->name, $this->email, $this->mobile, $this->address, $this->fee, $this->specialization);

			if($stmt->execute()){
				return true;
			}
		}
	}

	public function update(){

		if($this->id) {

			$stmt = $this->conn->prepare("
				UPDATE ".$this->consultantTable."
				SET name= ?, email = ?, mobile = ?, address = ?, fee = ?, specialization = ?
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->mobile = htmlspecialchars(strip_tags($this->mobile));
			$this->address = htmlspecialchars(strip_tags($this->address));
			$this->fee = htmlspecialchars(strip_tags($this->fee));
			$this->specialization = htmlspecialchars(strip_tags($this->specialization));

			$stmt->bind_param("ssssisi", $this->name, $this->email, $this->mobile, $this->address, $this->fee, $this->specialization, $this->id);

			if($stmt->execute()){
				return true;
			}

		}
	}

	public function delete(){
		if($this->id) {

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->consultantTable."
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	}

	public function getTotalconsultant(){
		$stmt = $this->conn->prepare("
		SELECT *
		FROM ".$this->consultantTable);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows;
	}



}
?>
