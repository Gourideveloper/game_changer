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
          <div class="col-sm-4">
            <h1 class="m-0">Assessments</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="assessments_choice.php" class="btn btn-md btn-info">Back</a>
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
          <div class="col-sm-4">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="background-color: white;">
            <?php
              if(isset($_POST['assessment_choice'])) {
                $team_id = $_POST['team_name'];

                $teamQuery = "SELECT * FROM teams WHERE team_id = '$team_id'";
                $teamQuery_execute = mysqli_query($conn, $teamQuery);

                if(mysqli_num_rows($teamQuery_execute) > 0) {
                  while($row = mysqli_fetch_assoc($teamQuery_execute)) {
            ?>
            <h3 style="padding: 8px;"> <strong>Team: </strong><?php echo $row['team_name']; ?> </h3>
            <?php
                  }
                }
              }
            ?>
            <?php
              if (isset($_POST['assessment_choice'])) {
                  $team_id = $_POST['team_name'];
                  $assessment_date = $_POST['assessment_date'];

                  // Fetch movements for the selected team
                  $movement_query = "SELECT team_movements.id as team_movement_id, movements.movement_id, movements.movement_name 
                                    FROM movements
                                    INNER JOIN team_movements ON movements.movement_id = team_movements.movement_id
                                    WHERE team_movements.team_id = '$team_id'";
                  $movement_query_execute = mysqli_query($conn, $movement_query);

                  if (mysqli_num_rows($movement_query_execute) > 0) {
                      $movements = [];
                      while ($movementData = mysqli_fetch_assoc($movement_query_execute)) {
                          $movements[] = $movementData;
                      }

                      // Fetch assessment data for the selected team, date, and movements
                      $assessment_query = "SELECT athletes.athlete_id, athletes.athlete_name, team_movements.id as team_movement_id, assessments.numerical_value
                                          FROM athletes
                                          CROSS JOIN team_movements
                                          LEFT JOIN assessments ON athletes.athlete_id = assessments.athlete_id 
                                                             AND team_movements.id = assessments.team_movement_id 
                                                             AND assessments.assessment_date = '$assessment_date'
                                          WHERE athletes.athlete_team_id = '$team_id'
                                          ORDER BY athletes.athlete_id, team_movements.id";
                      $assessment_query_execute = mysqli_query($conn, $assessment_query);

                      if (mysqli_num_rows($assessment_query_execute) > 0) {
              ?>
                          <table id="example1" class="table table-bordered table-striped" style="padding: 8px; display: block;
                              max-width: -moz-fit-content; max-width: fit-content; margin: 0 auto; white-space: nowrap;">
                              <thead>
                                  <tr>
                                      <th>Athlete Name</th>
                                      <?php foreach ($movements as $movement) { ?>
                                          <th><?php echo $movement["movement_name"]; ?></th>
                                      <?php } ?>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  $currentAthleteId = null;
                                  while ($assessmentData = mysqli_fetch_assoc($assessment_query_execute)) {
                                      if ($assessmentData['athlete_id'] !== $currentAthleteId) {
                                          if ($currentAthleteId !== null) {
                                              echo '</tr>';
                                          }
                                          $currentAthleteId = $assessmentData['athlete_id'];
                                          echo '<tr><td>' . $assessmentData['athlete_name'] . '</td>';
                                      }

                                      $numericalValue = $assessmentData['numerical_value'];
                                      echo '<td>' . ($numericalValue !== null ? $numericalValue : '') . '</td>';
                                  }
                                  echo '</tr>';
                                  ?>
                              </tbody>
                          </table>
              <?php
                      } else {
                          echo "No assessment data found for the selected team and date.";
                      }
                  } else {
                      echo "No movements found for the selected team.";
                  }
              }
              ?>
          </div>
            <!-- </div> -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>

<?php

	include('../includes/footer.php');

?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#example1').DataTable({
      'scrollX': true
    });

    // Get column names and numbers dynamically
    var editableColumns = [];
    <?php
      if(isset($_POST['assessment_choice'])) {
        $team_id = $_POST['team_name'];
        $assessment_date = $_POST['assessment_date'];

        $query = "SELECT team_movements.id as team_movement_id, movements.movement_id, movements.movement_name FROM movements
                                INNER JOIN team_movements ON movements.movement_id = team_movements.movement_id
                                WHERE team_movements.team_id = '$team_id'";
        $query_execute = mysqli_query($conn, $query);

        if(mysqli_num_rows($query_execute) > 0) {
          $columnNumber = 2;
          while($data = mysqli_fetch_assoc($query_execute)) {
            echo "editableColumns.push([" . $columnNumber . ", '" . $data['movement_id'] . "']);";
            $columnNumber++;
          }
        }
      }
    ?>

    // Live Editing Table
    $('#example1').Tabledit({
      url: 'assessmentsTable.php',
      editButton: false,
      deleteButton: false,
      columns: {
        identifier: [1, 'id'] ,
        editable: editableColumns
      },
      onSuccess: function (data, textStatus, jqXHR) {
        console.log("Tabledit success:", data);
        // Check the status in the returned data
        if (data.status === 'success') {
            swal({
                icon: 'success',
                title: 'Success!',
                text: data.message,
            }).then(() => {
                // Reload the page or update the table as needed
                location.reload();
            });
        } else {
            swal({
                icon: 'error',
                title: 'Error',
                text: data.message,
            }).then(() => {
                // Reload the page or update the table as needed
                location.reload();
            });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // Handle the error condition
        swal({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred during the request.',
        }).then(() => {
            // Reload the page or update the table as needed
            location.reload();
        });
      },
    })
  });
</script>

<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
?>