<?php
include_once 'config/Database.php';
include_once 'class/Client.php';

$database = new Database();
$db = $database->getConnection();

$client = new Client($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listclient') {
	$client->listclients();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getclient') {
	$client->id = $_POST["id"];
	$client->getclient();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addclient') {
	$client->name = $_POST["name"];
    $client->gender = $_POST["gender"];
    $client->age = $_POST["age"];
	$client->email = $_POST["email"];
	$client->mobile = $_POST["mobile"];
	$client->address = $_POST["address"];
	$client->medical_history = $_POST["history"];
	$client->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateclient') {
	$client->id = $_POST["id"];
	$client->name = $_POST["name"];
    $client->gender = $_POST["gender"];
    $client->age = $_POST["age"];
	$client->email = $_POST["email"];
	$client->mobile = $_POST["mobile"];
	$client->address = $_POST["address"];
	$client->medical_history = $_POST["history"];
	$client->update();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteclient') {
	$client->id = $_POST["id"];
	$client->delete();
}
?>
