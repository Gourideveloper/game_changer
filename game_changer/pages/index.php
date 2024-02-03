<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['coach_name'])) {

?>

<?php 

	include('../includes/header.php');
	include('../includes/top-navbar.php');
	include('../includes/side-navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-image: url('../assets/img/home_page.jpg'); background-repeat: no-repeat; background-size: cover;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <h1 class="text-white" style="font-size: 75px; margin: 150px 370px;">Game Changer</h1>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
</div>

<?php

	include('../includes/footer.php');

?>

<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
 ?>