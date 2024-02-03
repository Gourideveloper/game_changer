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
            <h1 class="m-0">Edit/Update Athlete Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <?php
                  if(isset($_GET['athlete_id'])) {
                    $athlete_id = $_GET['athlete_id'];

                    $query = "SELECT athlete_team_id FROM athletes WHERE athlete_id = '$athlete_id'";
                    $query_execute = mysqli_query($conn, $query);

                    if(mysqli_num_rows($query_execute) > 0) {
                      while($data = mysqli_fetch_assoc($query_execute)) {
                ?>
                <a href="team_info.php?team_id=<?php echo $data["athlete_team_id"]; ?>" class="btn btn-md btn-info">Back</a>
                <?php
                      }
                    } 
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
                          <?php 
                            if(isset($_GET["athlete_id"])) {
                              $athlete_id = $_GET["athlete_id"];

                              $query = "SELECT * FROM athletes WHERE athlete_id='$athlete_id'";
                              $query_execute = mysqli_query($conn, $query);

                              if(mysqli_num_rows($query_execute) > 0) {
                              foreach ($query_execute as $data) {
                          ?>
                          <div class="form-group">
                            <input type="hidden" name="athlete_id" value="<?php echo $data['athlete_id']; ?>">
                            <label class="form-label" for="athleteName">Athlete Name</label>
                            <input type="text" class="form-control" id="athleteName" name="athlete_name" placeholder="Athlete Name here..." value="<?php echo $data['athlete_name']; ?>" required />
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="customFile">Athlete Image</label>
                            <input type="file" class="form-control" id="imageFile" name="athlete_image" value="<?php echo $data['athlete_image'] ?>"/>
                          </div>
                          <img src="<?php echo "../assets/img/athlete_images/".$data['athlete_image'];?>" width="100px">
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteSID">Athlete 919#</label>
                            <input type="text" class="form-control" id="athleteSID" name="athlete_SID" value="<?php echo $data['athlete_SID']; ?>" required />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteAge">Athlete Age</label>
                            <input type="number" class="form-control" id="athleteAge" name="athlete_age" placeholder="Athlete Age here..." value="<?php echo $data['athlete_age']; ?>" required  />
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteHeight">Athlete Height</label>
                            <input type="number" class="form-control" id="athleteHeight" name="athlete_height" placeholder="Athlete Height here..." value="<?php echo $data['athlete_height']; ?>" step="any" required />
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteWeight">Athlete Weight</label>
                            <input type="number" class="form-control" id="athleteWeight" name="athlete_weight" placeholder="Athlete Weight here..." value="<?php echo $data['athlete_weight']; ?>" step="any" required />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteStatus">Athlete Status</label>
                            <select id="athleteStatus" class="form-control" name="athlete_status">
                              <?php 
                                if($data['athlete_status'] == "Active") {
                              ?>
                              <option disabled>Choose Status</option>
                              <option value="Active" selected>Active</option>
                              <option value="Inactive">Inactive</option>
                              <?php
                                } else {
                              ?>
                              <option disabled>Choose Status</option>
                              <option value="Active">Active</option>
                              <option value="Inactive" selected>Inactive</option>
                              <?php
                                } 
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label class="form-label" for="athleteTeam">Athlete Team</label>
                            <select id="athleteTeam" class="form-control" name="athlete_team">
                              <option disabled>Choose Teams</option>
                              <?php
                                $query = "SELECT * FROM teams ORDER BY team_id ASC";
                                $query_execute = mysqli_query($conn, $query);

                                if(mysqli_num_rows($query_execute) > 0) {
                                  while($row = mysqli_fetch_assoc($query_execute)) {
                                    if($row['team_id'] == $data['athlete_team_id']) {
                              ?>
                              <option name="<?php echo $row['team_name']; ?>" value="<?php echo $row['team_id']; ?>" selected>
                                <?php echo $row['team_name']; ?>
                                </option>
                              <?php
                                } else {
                              ?>
                              <option name="<?php echo $row['team_name']; ?>" value="<?php echo $row['team_id']; ?>">
                                <?php echo $row['team_name']; ?>
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
                          <a href="team_info.php?team_id=<?php echo $data['athlete_team_id']; ?>" class="btn btn-default">Cancel</a>
                          <button type="submit" class="btn btn-success" name="updateAthlete">Update</button>
                        </div>
                      </div>
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