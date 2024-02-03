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
            <h1 class="m-0">Add Assessment</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="assessments.php" class="btn btn-md btn-info">Back</a>
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
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="form-label" for="teamName">Choose Team</label>
                            <select id="teamName" class="form-control" name="team_name">
                              <option disabled selected>Choose Teams</option>
                              <?php  
                                $query = "SELECT * FROM teams ORDER BY team_id ASC";
                                $query_execute = mysqli_query($conn, $query);

                                if(mysqli_num_rows($query_execute) > 0) {
                                  while($data = mysqli_fetch_assoc($query_execute)) {
                              ?>
                              <option name="<?php echo $data['team_name']; ?>" value="<?php echo $data['team_id']; ?>">
                                <?php echo $data['team_name']; ?>
                              </option>
                              <?php
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="form-label" for="athleteName">Choose Athlete Name</label>
                            <select id="athleteName" class="form-control" name="athlete_name">
                              <option disabled selected>Choose Athletes</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="form-label" for="movementName">Choose Athlete Name</label>
                            <select id="movementName" class="form-control" name="movement_name">
                              <option disabled selected>Choose Movements</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="form-label" for="numericalAssessment">Numerical Assessment</label>
                            <input id="numericalAssessment" type="number" class="form-control" name="numerical_assessment" placeholder="Numerical Assessment value...." step="any">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="form-label" for="assessmentDate">Choose Date</label>
                            <input id="assessmentDate" type="date" class="form-control" name="assessment_date">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="form-label" for="attendance">Attendance</label>
                            <select id="attendance" class="form-control" name="attendance">
                              <option disabled selected>Choose Athlete Attendance</option>
                              <option value="Present">Present</option>
                              <option value="Absent">Absent</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                         <div class="modal-footer justify-content-between">
                          <a href="assessments.php" class="btn btn-default">Cancel</a>
                          <button type="submit" class="btn btn-success" name="addAssessment">Add</button>
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

<script>
  $(document).ready(function () {

    // Function to fetch athletes based on the selected team
    function loadAthletes(teamId) {
      $.ajax({
        type: 'POST',
        url: 'get_athletes.php', 
        data: { teamId: teamId },
        success: function (response) {
          $('#athleteName').html(response);
        }
      });
    }

    // Function to fetch movements based on the selected team
    function loadMovements(teamId) {
      $.ajax({
        type: 'POST',
        url: 'get_movements.php', 
        data: { teamId: teamId },
        success: function (response) {
          $('#movementName').html(response);
        }
      });
    }

    // Event handler for team selection change
    $('#teamName').change(function () {
      var selectedTeamId = $(this).val();
      if (selectedTeamId) {
        // Load athletes and movements based on the selected team
        loadAthletes(selectedTeamId);
        loadMovements(selectedTeamId);
      } else {
        // Clear the athlete and movement dropdowns if no team is selected
        $('#athleteName').html('<option></option>');
        $('#movementName').html('<option></option>');
      }
    });
  });
</script>


<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
 ?>