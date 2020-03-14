<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=aangifte");
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
$update = $con->query("UPDATE cjib SET 
	name = '".$con->real_escape_string($_POST['name'])."',
	steam = '".$con->real_escape_string($_POST['steam'])."',
	phone = '".$con->real_escape_string($_POST['phone'])."',
	dob = '".$con->real_escape_string($_POST['dob'])."',
	job = '".$con->real_escape_string($_POST['job'])."',
	open = '".$con->real_escape_string($_POST['open'])."',
	term = '".$con->real_escape_string($_POST['term'])."',
	last_contact = '".$con->real_escape_string($_POST['last_contact'])."',
	reminded = '".$con->real_escape_string($_POST['reminded'])."',
	owned_stuff = '".$con->real_escape_string($_POST['owned_stuff'])."',
	owned_properties = '".$con->real_escape_string($_POST['owned_properties'])."',
	status = '".$con->real_escape_string($_POST['status'])."'
	WHERE
	id = '".$con->real_escape_string($_GET['id'])."'
");

Header("Location: /cjib_dossier?id=".$_GET['id']);
}

$get = $con->query("SELECT * FROM cjib WHERE id='".$con->real_escape_string($_GET['id'])."'");
$row = $get->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Zoutelande - <?php echo $row['number']; ?></title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  
  <!-- datatables -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<link rel="icon" type="image/png" href="favicon.ico" />
<meta name="theme-color" content="<?php echo $browser_color; ?>">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/">Zoutelande - MEOS</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="/gms">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Portofoon</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="basisadministratie">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Basisadministratie</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="voertuigregistratie">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Voertuigregistratie</span>
          </a>
        </li>
		<?php if (@$_SESSION['cjib'] == 1) { ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="cjib">
            <i class="fa fa-fw fa-list"></i>
            <span class="nav-link-text">CJIB</span>
          </a>
        </li>
		<?php } ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="training">
            <i class="fa fa-fw fa-book"></i>
            <span class="nav-link-text">Training</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="aangiftes">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text"><u>Aangifteadministratie</u></span>
          </a>
        </li>
				<?php if ($_SESSION['role'] == "admin") { ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="gebruikers">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Gebruikersadministratie</span>
          </a>
        </li>
		
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="jaillog">
            <i class="fa fa-fw fa-cogs"></i>
            <span class="nav-link-text">Logboeken</span>
          </a>
        </li>
		<?php } ?>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index">Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href='/cjib'>Centraal Justitueel Incassobureau</a></li> 
        <li class="breadcrumb-item active"><?php echo $row['number']; ?></li> 
		</ol>
		<form method="POST" id="new" name="new">
		<input type="hidden" name="form" value="new">
		<label for='name'><em><b>Volledige naam:</b></em></label>
		<input type="text" name="name" id="name" class="form-control" value="<?php echo $row['name']; ?>"><br>
		<label for='steam'><em><b>Steamnaam:</b></em></label>
		<input type="text" name="steam" id="steam" class="form-control" value="<?php echo $row['steam']; ?>"><br>
		<label for='phone'><em><b>Telefoonnummer:</b></em></label>
		<input type="text" name="phone" id="phone" class="form-control" value="<?php echo $row['phone']; ?>"><br>
		<label for='dob'><em><b>Geboortedatum:</b></em></label>
		<input type="text" name="dob" id="dob" placeholder="17-04-1997" class="form-control" value="<?php echo $row['dob']; ?>"><br>
		<label for='job'><em><b>Beroep:</b></em></label>
		<input type="text" name="job" id="job" placeholder="Buschauffeur" class="form-control" value="<?php echo $row['job']; ?>"><br>
		<label for='open'><em><b>Openstaand bedrag:</b></em></label>
		<input type="text" name="open" id="open" placeholder="&euro; 50.000" class="form-control" value="<?php echo $row['open']; ?>"><br>
		<label for='term'><em><b>Betalingstermijn:</b></em></label>
		<input type="text" name="term" id="term" placeholder="4 maanden" class="form-control" value="<?php echo $row['term']; ?>"><br>
		<label for='last_contact'><em><b>Laatste contactmoment:</b></em></label>
		<input type="text" name="last_contact" id="last_contact" value="<?php echo $row['last_contact']; ?>" class="form-control"><a href="#" onclick="currentDate();">(vandaag)</a><br>
		<label for='reminded'><em><b>Dagtekening laatste herinnering:</b></em></label>
		<input type="text" name="reminded" id="reminded" value="<?php echo $row['reminded']; ?>" class="form-control" placeholder="<?php echo $row['reminded']; ?>"><br>
		<label for='user'><em><b>Ambtenaar:</b></em></label>
		<input type="text" name="user" id="user" value="<?php echo $row['user']; ?>" class="form-control" readonly><hr>
		<label for='owned_stuff'><em><b>Eigendommen:</b></em></label>
		<textarea name="owned_stuff" id="owned_stuff" class="form-control"><?php echo $row['owned_stuff']; ?></textarea><br>
		<label for='owned_properties'><em><b>Vastgoed:</b></em></label>
		<textarea name="owned_properties" id="owned_properties" class="form-control"><?php echo $row['owned_properties']; ?></textarea><br>
		<label for='status'><em><b>Status:</b></em></label>
		<select class="form-control" name="status" id="status">
			<option <?php if ($row['status'] == 'open') { echo 'selected';} ?> value="open">Geopend</option>
			<option <?php if ($row['status'] == 'closed') { echo 'selected';} ?> value="closed">Gesloten</option>
			<option <?php if ($row['status'] == 'wanted') { echo 'selected';} ?> value="wanted">Gezocht</option>
		</select><br>
		<input type="submit" value="Opslaan" class="btn btn-primary">
		<a href="/cjib" class="btn btn-secondary">Afbreken</a>
	</form>
  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Zoutelande</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
  <script>
  $('#badm').DataTable( {
    paging: false
} );
function currentDate() {
	event.preventDefault();
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();

	if (dd < 10) {
	  dd = '0' + dd;
	}

	if (mm < 10) {
	  mm = '0' + mm;
	}

	today = dd + '-' + mm + '-' + yyyy;
	console.log(today);
	document.getElementById('last_contact').value=today;
}
</script>
</body>

</html>