<?php

include_once 'config/Database.php';
include_once 'class/Consultant.php';

$database = new Database();
$db = $database->getConnection();

$consultant = new Consultant($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listconsultants') {
	$consultant->listconsultants();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getconsultant') {
	$consultant->id = $_POST["id"];
	$consultant->getconsultant();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addconsultant') {
	$consultant->name = $_POST["name"];
    $consultant->fee = $_POST["fee"];
    $consultant->specialization = $_POST["specialization"];
	$consultant->mobile = $_POST["mobile"];
	$consultant->address = $_POST["address"];
	$consultant->email = $_POST["email"];
	$consultant->insert();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateconsultant') {
	$consultant->id = $_POST["id"];
	$consultant->name = $_POST["name"];
    $consultant->fee = $_POST["fee"];
    $consultant->specialization = $_POST["specialization"];
	$consultant->mobile = $_POST["mobile"];
	$consultant->address = $_POST["address"];
	$consultant->email = $_POST["email"];
	$consultant->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteconsultant') {
	$consultant->id = $_POST["id"];
	$consultant->delete();
}
?>
