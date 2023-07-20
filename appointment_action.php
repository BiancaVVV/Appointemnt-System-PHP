<?php

include_once 'config/Database.php';
include_once 'class/Appointment.php';

$database = new Database();
$db = $database->getConnection();

$appointment = new Appointment($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listAppointment') {
	$appointment->listAppointment();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getAppointment') {
	$appointment->id = $_POST["id"];
	$appointment->getAppointment();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getSlots') {
	$appointment->consultantId = $_POST["consultantId"];
	$appointment->appointmentDate = $_POST["appointmentDate"];
	$appointment->getSlots();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateAppointment') {
	$appointment->id = $_POST["id"];
	$appointment->client_name = $_POST["client_name"];
	$appointment->consultant_id = $_POST["consultant_name"];
    $appointment->specialization_id = $_POST["specialization"];
    $appointment->fee = $_POST["fee"];
	$appointment->appointment_date = $_POST["appointment_date"];
	$appointment->appointment_time = $_POST["appointment_slot"];
	$appointment->status = $_POST["status"];
	$appointment->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'createAppointment') {
	$appointment->client_name = $_POST["client_name"];
	$appointment->consultant_id = $_POST["consultant_name"];
    $appointment->specialization_id = $_POST["specialization"];
    $appointment->fee = $_POST["fee"];
	$appointment->appointment_date = $_POST["appointment_date"];
	$appointment->appointment_time = $_POST["appointment_slot"];
	$appointment->status = $_POST["status"];
	$appointment->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteAppointment') {
	$appointment->id = $_POST["id"];
	$appointment->delete();
}

?>
