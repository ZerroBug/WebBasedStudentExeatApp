<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');
if (strlen($_SESSION['alogin']) == 0) {
header('location:index.php');
} else {

//Inactive  Employee    
if (isset($_GET['inid'])) {
$id = $_GET['inid'];
$status = 0;
$sql = "UPDATE tblstudents set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->bindParam(':status', $status, PDO::PARAM_STR);
$query->execute();
header('location:students.php');
}

//Activated Employee
if (isset($_GET['id'])) {
$id = $_GET['id'];
$status = 1;
$sql = "UPDATE tblstudents set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->bindParam(':status', $status, PDO::PARAM_STR);
$query->execute();
header('location:students.php');
}

if (isset($_GET['del'])) {
$id = $_GET['del'];
$sql = "DELETE from  tblstudents  WHERE id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$msg = "The selected student has been deleted";
}




?>

<!doctype html>
<html class="no-js" lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Admin Panel - Student List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/themify-icons.css">
<link rel="stylesheet" href="../assets/css/metisMenu.css">
<link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="../assets/css/slicknav.min.css">
<!-- amchart css -->
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<!-- Start datatable css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
<!-- others css -->
<link rel="stylesheet" href="../assets/css/typography.css">
<link rel="stylesheet" href="../assets/css/default-css.css">
<link rel="stylesheet" href="../assets/css/styles.css">
<link rel="stylesheet" href="../assets/css/responsive.css">
<!-- modernizr css -->
<script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
<!-- preloader area start -->
<div id="preloader">
<div class="loader"></div>
</div>
<!-- preloader area end -->

<div class="page-container">
<!-- sidebar menu area start -->
<div class="sidebar-menu">
<div class="sidebar-header">
<div class="logo">
<a href="dashboard.php"><img src="" alt="logo"></a>
</div>
</div>
<div class="main-menu">
<div class="menu-inner">
<?php
$page = 'student';
include '../includes/admin-sidebar.php';
?>
</div>
</div>
</div>
<!-- sidebar menu area end -->
<!-- main content area start -->
<div class="main-content">
<!-- header area start -->
<div class="header-area">
<div class="row align-items-center">
<!-- nav and search button -->
<div class="col-md-6 col-sm-8 clearfix">
<div class="nav-btn pull-left">
<span></span>
<span></span>
<span></span>
</div>

</div>
<!-- profile info & task notification -->
<div class="col-md-6 col-sm-4 clearfix">
<ul class="notification-area pull-right">
<li id="full-view"><i class="ti-fullscreen"></i></li>
<li id="full-view-exit"><i class="ti-zoom-out"></i></li>

<!-- Notification bell -->
<?php include '../includes/admin-notification.php' ?>

</ul>
</div>
</div>
</div>
<!-- header area end -->
<!-- page title area start -->
<div class="page-title-area">
<div class="row align-items-center">
<div class="col-sm-6">
<div class="breadcrumbs-area clearfix">
<h4 class="page-title pull-left">Student List</h4>
<ul class="breadcrumbs pull-left">
<li><a href="dashboard.php">Home</a></li>
<li><span>Student List</span></li>

</ul>
</div>
</div>


</div>
</div>
<!-- page title area end -->
<div class="main-content-inner">


<!-- row area start -->
<div class="row">
<!-- Dark table start -->
<div class="col-12 mt-5">

<div class="card">


<?php if ($error) { ?><div class="alert alert-danger alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($error); ?>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>

</div><?php } else if ($msg) { ?><div class="alert alert-success alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($msg); ?>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div><?php } ?>

<div class="card-body">
<div class="data-tables datatable-blue">
<button class="btn-success btn btn-md float-right mb-3"  onclick="window.print()">Print List</button>

<table id="dataTable" class="table table-hover table-striped text-center">
<thead class="text-capitalize">
<tr>
<th>#</th>
<th>Name</th>
<th>Index Number</th>
<th>House/Hall</th>


<th></th>
</tr>
</thead>
<tbody>

<?php
$sql = "SELECT StdId,FirstName,LastName,House,Status,RegDate,id from  tblstudents";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
foreach ($results as $result) {               ?>
<tr>
<td> <?php echo htmlentities($cnt); ?></td>

<td><?php echo htmlentities($result->FirstName); ?>&nbsp;<?php echo htmlentities($result->LastName); ?></td>

<td><?php echo htmlentities($result->StdId); ?></td>

<td><?php echo htmlentities($result->House); ?></td>




<td><a href="update-student.php?stdid=<?php echo htmlentities($result->id); ?>"><i class="fa fa-edit" style="color:green"></i></a>
<?php if ($result->Status == 1) { ?>
    <a href="students.php?inid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to inactive this student?');"" > <i class=" fa fa-times-circle" style="color:red" title="Inactive"></i>
    <?php } else { ?>

        <a href="students.php?id=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to active this student?');""><i class=" fa fa-check" style="color:green" title="Active"></i>
        <?php } ?>
</td>
</tr>
<?php $cnt++;
}
} ?>

</tbody>
</table>
</div>
</div>
</div>
</div>
<!-- Dark table end -->

</div>
<!-- row area end -->

</div>
<!-- row area start-->
</div>
<?php include '../includes/footer.php' ?>
</div>
<!-- main content area end -->


<!-- footer area end-->
</div>
<!-- jquery latest version -->
<script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
<!-- bootstrap 4 js -->
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/metisMenu.min.js"></script>
<script src="../assets/js/jquery.slimscroll.min.js"></script>
<script src="../assets/js/jquery.slicknav.min.js"></script>

<!-- start chart js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- start highcharts js -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- start zingchart js -->
<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
<script>

</script>
<!-- all line chart activation -->
<script src="assets/js/line-chart.js"></script>
<!-- all pie chart -->
<script src="assets/js/pie-chart.js"></script>

<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<!-- others plugins -->
<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/scripts.js"></script>


<script >
    

$(document).ready(function(){
      $('mytable').dataTable();

});



</script>
</body>

</html>

<?php } ?>