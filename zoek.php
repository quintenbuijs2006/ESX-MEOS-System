<?php
require "config.php";
if ($_SESSION['loggedin'] != TRUE) {
	Header("Location: login.php?returnpage=basisadministratie");
}

if ($_SESSION['rang'] == "G4S") {
	Header("Location: index");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (trim($_POST['q']) != NULL) {		
		Header("Location: zoek?q=".$_POST['q']);
	}
}

$mensenq = $ddcon->query("SELECT firstname, lastname, dateofbirth, aid FROM users WHERE LOWER(firstname) LIKE LOWER('%".$con->real_escape_string($_GET['q'])."%') OR LOWER(lastname) LIKE LOWER('%".$con->real_escape_string($_GET['q'])."%') OR LOWER(concat(firstname, ' ', lastname)) LIKE LOWER('%".$con->real_escape_string($_GET['q'])."%') ORDER BY lastname DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Basisadministratie | MEOS (<?php echo htmlspecialchars($_GET['q']); ?>)</title>
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
    <a class="navbar-brand" href="/">Basisadministratie | MEOS</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index">
            <i class="fa fa-fw fa-home"></i>
            <span class="nav-link-text">Homepagina</span>
          </a>
        </li>
		<?php if ($_SESSION['role'] != "anwb") { ?>
		<?php } ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="basisadministratie">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text"><u>Basisadministratie</u></span>
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
            <span class="nav-link-text">Aangifteadministratie</span>
          </a>
        </li>
		<?php if ($_SESSION['role'] == "admin") { ?>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="gebruikers">
            <i class="fa fa-fw fa-user-circle"></i>
            <span class="nav-link-text">Gebruikersadministratie</span>
          </a>
        </li>
		
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="jaillog">
            <i class="fa fa-fw fa-history"></i>
            <span class="nav-link-text">Logboeken</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="exit.php">
            <i class="fa fa-sign-out"></i>
            <span class="nav-link-text">Uitloggen</span>
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
        <li class="breadcrumb-item active">Basisadministratie</li>
      </ol>
		<form method="POST">
		<b><em>Zoeken:</em></b><br>
		<input type="text" name="q" class="form-control" placeholder="Voornaam -OF- Achternaam"><br>
		<input type="submit" value="Zoeken" class="btn btn-success btn-block">
		</form>
		<hr>
		<table id="badm" class="table">
		  <tr>
			<th>Actie</th>
			<th>Achternaam</th> 
			<th>Voornaam</th>
			<th>Geboortedatum</th>
			<th>ID</th>
		  </tr>
		  <?php
		  while ($row = $mensenq->fetch_assoc()) {  
		  ?>
		  <tr>
			<td><a href="gegevens?id=<?php echo $row['aid']; ?>">Muteren</a></td>
			<td><?php echo htmlspecialchars($row['lastname']); ?></td> 
			<td><?php echo htmlspecialchars($row['firstname']); ?></td>
			<td><?php echo htmlspecialchars($row['dateofbirth']); ?></td>
			<td><?php echo $row['aid']; ?></td>
		  </tr>
		  <?php 
		  }
		  ?>
		</table>

	  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Meerstad</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
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
</script>
</body>

</html>
