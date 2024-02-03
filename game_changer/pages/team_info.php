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
            <h1 class="m-0">Team Information</h1>
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
                <div class="row">
                  <?php
                    if(isset($_GET["team_id"])) {
                      
                        $team_id = $_GET["team_id"];

                        $query = "SELECT * FROM teams WHERE team_id='$team_id'";
                        $query_execute = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_execute) > 0) {
                          foreach ($query_execute as $row) {
                  ?>
                  <div class="col-md-4">
                    <img src="../assets/img/teams/<?php echo $row["team_image"]; ?>" style="width: 300px; height: 250px; border-radius: 15%;">
                  </div>
                  <div class="col-md-8">
                    <div class="card">
                      <div class="card-body">
                        <h1><?php echo $row["team_name"]; ?></h1>
                      </div>
                    </div>
                  </div>
                  <?php 
                        }
                      }
                    }
                  ?>
                </div>
                <br><br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-md-6">
                            <h2>Athletes</h2>
                          </div>
                          <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item">
                                <?php
                                  if(isset($_GET["team_id"])) {
                                      $team_id = $_GET["team_id"];
                                ?>
                                <a href="add_athletes.php?team_id=<?php echo $team_id ?>" class="btn btn-md btn-success">+ Add Athlete</a>
                                <?php
                                  }
                                ?>
                              </li>
                            </ol>
                          </div><!-- /.col -->
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <!-- small box -->
                            <?php
                              if(isset($_GET["team_id"])) {
                                $team_id = $_GET["team_id"];
                                $query = "SELECT * FROM athletes WHERE athlete_team_id='$team_id'";
                                $query_execute = mysqli_query($conn, $query);

                                if(mysqli_num_rows($query_execute) > 0) {
                                  foreach ($query_execute as $data) {
                            ?>      
                            <div class="col-lg-3 col-6">
                              <div class="small-box bg-warning">
                                <div class="icon" style="padding: 15px;">
                                  <img class="info-box-icon bg-info elevation-1" src="../assets/img/athlete_images/<?php echo $data['athlete_image']; ?>" style="width:150px; height:100px; border-radius:15%;">
                                </div>
                                <div class="inner">
                                  <p class="text-lg"><?=$data['athlete_name']; ?></p>
                                </div>
                                <ul class="list-inline m-0 small-box-footer">
                                  <li class="list-inline-item">
                                    <a href="edit_athletes.php?athlete_id=<?php echo $data['athlete_id']; ?>" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit" name="edit_athlete"><i class="fa fa-edit"></i></a>
                                  </li>        
                                  
                                  <li class="list-inline-item">
                                    <form action="code.php" method="POST">
                                      <input type="hidden" name="athlete_id" value="<?php echo $data['athlete_id']; ?>">
                                      <input type="hidden" name="athlete_image" value="<?php echo $data['athlete_image']; ?>">
                                      <input type="hidden" name="athlete_team_id" value="<?php echo $data['athlete_team_id']; ?>">
                                      <button type="submit" class="btn btn-danger btn-sm rounded-0">
                                        <i class="fa fa-trash"></i>
                                      </button>
                                    </form>
                                  </li>        

                                  <li class="list-inline-item">
                                    <a href="athlete_profile.php?athlete_id=<?php echo $data['athlete_id']; ?>" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                                  </li>
                                </ul>     
                              </div>
                            </div>
                            <!-- ./col -->
                            <?php  
                                  }
                                }
                              }
                            ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-md-6">
                            <h2>Movements</h2>
                          </div>
                          <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item">
                                <?php
                                  if(isset($_GET["team_id"])) {
                                    $team_id = $_GET["team_id"];
                                ?>
                                <a href="add_team_movements.php?team_id=<?php echo $team_id; ?>" class="btn btn-md btn-success">+ Add Movement</a>
                                <?php 
                                  }
                                ?>
                              </li>
                            </ol>
                          </div><!-- /.col -->
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <?php 
                              if(isset($_GET['team_id'])) {
                                $team_id = $_GET['team_id'];

                                $query = "SELECT movements.movement_id, movements.movement_name FROM movements
                                          INNER JOIN team_movements ON movements.movement_id = team_movements.movement_id
                                          WHERE team_movements.team_id = '$team_id'";
                                $query_execute = mysqli_query($conn, $query);

                                if(mysqli_num_rows($query_execute) > 0) {
                                  while($data = mysqli_fetch_assoc($query_execute)) {
                            ?>
                          <div class="col-md-3">
                            <!-- Sample Movement Cell -->
                            <div style="border: 1px solid #ddd; padding: 10px; margin: 10px;
                                        border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                        display: flex; align-items: center; justify-content: space-between;">
                              <div style="flex-grow: 1;">
                                <p><strong> <?php echo $data["movement_name"]; ?> </strong></p>
                              </div>
                              <div style="display: flex; align-items: center;">
                                <div style="border-left: 1px solid #ddd; height: 30px; margin: 0 10px;"></div>
                                <form action="code.php" method="POST">
                                  <input type="hidden" name="movement_id" value="<?php echo $data["movement_id"]; ?>">
                                  <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
                                  <button type="submit" class="btn btn-danger btn-sm rounded-0">
                                    <i class="fa fa-trash"></i>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                          <?php 
                                }
                              }
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>                                             
                </div>
              <!-- /.row -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
    </section>
</div>

<?php

	include('../includes/footer.php');

?>

<?php 
} else {
     header("Location: ../login-logout/login.php");
     exit();
}
?>