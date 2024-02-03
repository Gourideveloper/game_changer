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

<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Athlete</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <?php
                  if(isset($_GET['team_id'])) {
                    $team_id = $_GET['team_id'];
                ?>
                <a href="team_info.php?team_id=<?php echo $team_id; ?>" class="btn btn-md btn-info">Back</a>
                <?php
                  } else {
                ?>
                <a href="athletes.php" class="btn btn-md btn-info">Back</a>
                <?php
                  }
                ?>
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  <form action="code.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteName">Athlete Name</label>
                            <input type="text" class="form-control" id="athleteName" name="athlete_name" placeholder="Athlete Name here..." required />
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="customFile">Athlete Image</label>
                            <input type="file" class="form-control" id="imageFile" name="athlete_image" required />
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteSID">Athlete 919#</label>
                            <input type="text" class="form-control" id="athleteSID" name="athlete_SID" required />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteAge">Athlete Age</label>
                            <input type="number" class="form-control" id="athleteAge" name="athlete_age" placeholder="Athlete Age here..." required  />
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteHeight">Athlete Height</label>
                            <input type="number" class="form-control" id="athleteHeight" name="athlete_height" placeholder="Athlete Height here..." step="any" required />
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteWeight">Athlete Weight</label>
                            <input type="number" class="form-control" id="athleteWeight" name="athlete_weight" placeholder="Athlete Weight here..." step="any" required />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteStatus">Athlete Status</label>
                            <select id="athleteStatus" class="form-control" name="athlete_status">
                              <option disabled selected>Choose Status</option>
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>
                            </select>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteTeam">Athlete Team</label>
                            <select id="athleteTeam" class="form-control" name="athlete_team">
                              <option disabled selected>Choose Teams</option>
                              <?php
                                if(isset($_GET['team_id'])) {
                                  $team_id = $_GET['team_id'];

                                  $query = "SELECT * FROM teams WHERE team_id='$team_id'";
                                  $query_execute = mysqli_query($conn, $query);

                                  if(mysqli_num_rows($query_execute) > 0) {
                                    while($data = mysqli_fetch_assoc($query_execute)) {
                              ?>
                              <option name="<?php echo $data['team_name']; ?>" value="<?php echo $data['team_id']; ?>" selected>
                                <?php echo $data['team_name']; ?>
                              </option>
                              <?php
                                    }  
                                  }
                                } else {
                                  $query = "SELECT * FROM teams";
                                  $query_execute = mysqli_query($conn, $query);

                                  if(mysqli_num_rows($query_execute) > 0) {
                                    while($data = mysqli_fetch_assoc($query_execute)) {
                              ?>
                              <option name="<?php echo $data['team_name']; ?>" value="<?php echo $data['team_id']; ?>">
                                <?php echo $data['team_name']; ?>
                              <?php
                                    }
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="modal-footer justify-content-between">
                          <?php
                            if(isset($_GET['team_id'])) {
                              $team_id = $_GET['team_id'];
                          ?>
                          <a href="team_info.php?team_id=<?php echo $team_id; ?>" class="btn btn-default">Cancel</a>
                          <?php
                            } else {
                          ?>
                          <a href="athletes.php" class="btn btn-default">Cancel</a>
                          <?php
                            }
                          ?>
                          <button type="submit" class="btn btn-success" name="addAthlete">Add</button>
                        </div>
                      </div>
                    </div>
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