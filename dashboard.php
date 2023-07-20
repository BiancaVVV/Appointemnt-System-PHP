<?php
include_once 'config/Database.php';
include_once 'class/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!$user->loggedIn()) {
	header("Location: index.php");
}

include_once 'class/Consultant.php';
include_once 'class/Client.php';
include_once 'class/Appointment.php';
$consultant = new Consultant($db);
$client = new Client($db);
$appointment = new Appointment($db);
include('inc/header4.php');
?>
<title>Dashboard</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>

  <div class="container-fluid" id="main">
  <?php include('top_menus.php'); ?>
    <div class="row row-offcanvas row-offcanvas-left">
      <?php include('left_menus.php'); ?>
      <div class="col-md-9 col-lg-10 main">
		<h2>Dashboard</h2>
        <div class="row mb-3">
          <div class="col-xl-3 col-lg-6">
            <div class="card card-inverse card-success">
              <div class="card-block bg-success">
                <div class="rotate">
                  <i class="fa fa-user fa-5x"></i>
                </div>
                <h6 class="text-uppercase">consultants</h6>
                <h1 class="display-1"><a href="consultant.php"><?php echo $consultant->getTotalconsultant(); ?></a></h1>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6">
            <div class="card card-inverse card-info">
              <div class="card-block bg-info">
                <div class="rotate">
                  <i class="fa fa-twitter fa-5x"></i>
                </div>
                <h6 class="text-uppercase">clients</h6>
                <h1 class="display-1"><a href="client.php"><?php echo $client->getTotalclient(); ?></a></h1>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-6">
            <div class="card card-inverse card-warning">
              <div class="card-block bg-warning">
                <div class="rotate">
                  <i class="fa fa-share fa-5x"></i>
                </div>
                <h6 class="text-uppercase">Appointment</h6>
                <h1 class="display-1"><a href="appointment.php"><?php echo $appointment->getTotalApointment(); ?></a></h1>
              </div>
            </div>
          </div>
        </div>
        <hr>
       </div>
      </div>
    </div>
  </body>
</html>
