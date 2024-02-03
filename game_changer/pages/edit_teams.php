<?php

  session_start();
  if (isset($_SESSION['id']) && isset($_SESSION['coach_name'])) {
?>

<?php 
  
  include('../database/db_conn.php');
	include('../includes/header.php');
	include('../includes/top-navbar.php');
	include('../includes/side-navbar.php');
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php
              if(isset($_SESSION['status'])) {
                echo "<h5>".$_SESSION['status']."</h5>";
                unset($_SESSION['status']);
              }
            ?>
            <h1 class="m-0">Edit Teams</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="teams.php" class="btn btn-md btn-info">Back</a>
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form action="code.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                      <?php 

                        if(isset($_GET['team_id'])) {
                          $team_id = $_GET['team_id'];
                          $query = "SELECT * FROM teams WHERE team_id='$team_id'";
                          $query_execute = mysqli_query($conn, $query);

                          if(mysqli_num_rows($query_execute) > 0) {
                            foreach ($query_execute as $data) {
                      ?>
                        <input type="hidden" name="team_id" value="<?php echo $data['team_id']; ?>">
                        <div class="form-group">
                          <label class="form-label" for="teamName">Team Name</label>
                          <input type="text" class="form-control" id="teamName" name="team_name" placeholder="Team Name here..." value="<?php echo $data['team_name']; ?>">
                        </div>
                        <div class="form-group">
                          <label class="form-label" for="customFile">Team Image</label>
                          <input type="file" class="form-control" id="imageFile" name="team_image" />
                          <input type="hidden" class="form-control" name="old_team_image" value="<?php echo $data['team_image']; ?>" />
                        </div>
                        <img src="<?php echo "../assets/img/teams/".$data['team_image'];?>" width="100px">
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" onclick="location.href='teams.php'">Cancel</button>
                        <button type="submit" class="btn btn-success" name="updateTeam">Update</button>
                      </div>

                      <?php
                            }
                          }
                        }
                      ?>
                  </form>
                </div>
              </div>
            </div>
            <!-- ./col -->
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