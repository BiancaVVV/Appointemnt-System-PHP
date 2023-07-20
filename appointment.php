<?php

include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Appointment.php';
include_once 'class/Client.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
if(!$user->loggedIn()) {
	header("Location: index.php");
}
$appointment = new Appointment($db);
$client = new Client($db);
include('inc/header4.php');
?>
<script src="js/appointment.js"></script>
</head>
<body>

	<div class="container-fluid">
	<?php include('top_menus.php'); ?>
		<div class="row row-offcanvas row-offcanvas-left">
			<?php include('left_menus.php'); ?>
			<div class="col-md-9 col-lg-10 main">
			<h2>Manage Appointment</h2>
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<?php if($user->isAdmin()) { ?>
				<div class="col-md-2" align="right">
					<button type="button" id="createAppointment" class="btn btn-success" title="Create Appointment"><span class="glyphicon glyphicon-plus">Add</span></button>
				</div>
				<?php } ?>
			</div>
		</div>
		<table id="appointmentListing" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>client</th>
					<th>consultant</th>
					<th>Specialization</th>
					<th>Fee</th>
					<th>Apointment Time</th>
					<th>Apointment Date</th>
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
	</div>
	<div id="appointmentModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="appointmentForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal"></button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Record</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group"
							<label for="client_name" class="control-label">client</label>
							<select class="form-control" id="client_name" name="client_name"/>
							<?php
							$result = $client->clientList();
							while ($clients = $result->fetch_assoc()) {
							?>
								<option value="<?php echo $clients['id']; ?>"><?php echo $clients['name']; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="form-group"
							<label for="consultant" class="control-label">consultant</label>
							<select class="form-control" id="consultant_name" name="consultant_name"/>
							<?php
							$result = $appointment->consultantList();
							while ($consultant = $result->fetch_assoc()) {
							?>
								<option value="<?php echo $consultant['id']; ?>"><?php echo $consultant['name']; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="specialization" class="control-label">Specialization</label>
							<select class="form-control" id="specialization" name="specialization"/>
							<?php
							$result = $appointment->specializationList();
							while ($specialization = $result->fetch_assoc()) {
							?>
								<option value="<?php echo $specialization['id']; ?>"><?php echo ucfirst($specialization['specialization']); ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="fee" class="control-label">Fee</label>
							<input type="text" class="form-control" id="fee" name="fee" placeholder="fee">
						</div>
						<div class="form-group">
							<label for="appointment_date" class="control-label">Appointment Date</label>
							<input type="date" class="form-control"  id="appointment_date" name="appointment_date" value="<?php echo date('d-m-Y'); ?>">

						</div>

						<div class="form-group">
							<label for="appointment_slot" class="control-label">Appointment Slots</label>
							<select class="form-control" id="appointment_slot" name="appointment_slot">
							</select>
						</div>
						<div class="form-group">
							<label for="description" class="control-label">Active</label>
							<select class="form-control" id="status" name="status"/>
								<option value="Active">Active</option>
								<option value="Completed">Completed</option>
								<option value="Cancelled">Cancelled</option>
							</select>
						</div>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="id" id="id" />
    					<input type="hidden" name="action" id="action" value="" />
    					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>

	<div id="appointmentDetails" class="modal fade">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Appointment Details</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name" class="control-label">client Name:</label>
						<span id="a_client"></span>
					</div>
					<div class="form-group">
						<label for="p_gender" class="control-label">consultant:</label>
						<span id="a_consultant"></span>
					</div>
					<div class="form-group">
						<label for="p_age" class="control-label">Specialization:</label>
						<span id="a_special"></span>
					</div>
					<div class="form-group">
						<label for="a_fee" class="control-label">Fee:</label>
						<span id="a_fee"></span>
					</div>
					<div class="form-group">
						<label for="phone" class="control-label">Appoint Date Time:</label>
						<span id="a_time"></span>
					</div>
					<div class="form-group">
						<label for="a_status" class="control-label">Status:</label>
						<span id="a_status"></span>
					</div>

				</div>
			</div>
    	</div>
	</div>
</div>
</body>
</html>
