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
            <h1 class="m-0">Athlete Profile</h1>
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
                    if(isset($_GET["athlete_id"])) {
                        $athlete_id = $_GET["athlete_id"];
                        $query = "SELECT * FROM athletes WHERE athlete_id='$athlete_id'";
                        $query_execute = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_execute) > 0) {
                          foreach ($query_execute as $row) {
                  ?>
                  <div class="col-md-4">
                    <img src="../assets/img/athlete_images/<?php echo $row["athlete_image"]; ?>" style="width: 300px; height: 250px; border-radius: 15%;">
                  </div>
                  <div class="col-md-8">
                    <div class="card">
                      <div class="card-body">
                        <h1><?php echo $row["athlete_name"]; ?></h1>
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
                            <h2>Assessments</h2>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <form action="" method="POST">
                          <div class="row">
                            <div class="col-md-4">
                              <label for="assessmentDate">Choose Date</label>
                              <input type="date" class="form-control" name="assessment_date">
                            </div>
                            <div class="col-md-4">
                              <label for="movementName">Choose Movement</label>
                              <select id="movementName" class="form-control" name="movement_name">
                                  <option selected disabled>Choose Movement</option>
                                  <?php
                                  if (isset($_GET["athlete_id"])) {
                                      $athlete_id = $_GET["athlete_id"];

                                      // Fetch the team ID of the athlete
                                      $team_query = "SELECT athlete_team_id FROM athletes WHERE athlete_id = '$athlete_id'";
                                      $team_query_execute = mysqli_query($conn, $team_query);

                                      if (mysqli_num_rows($team_query_execute) > 0) {
                                          $teamData = mysqli_fetch_assoc($team_query_execute);
                                          $athlete_team_id = $teamData['athlete_team_id'];

                                          // Fetch movements for the athlete's team
                                          $movement_query = "SELECT team_movements.id as team_movement_id, movements.movement_id, movements.movement_name 
                                                            FROM movements
                                                            INNER JOIN team_movements ON movements.movement_id = team_movements.movement_id
                                                            WHERE team_movements.team_id = '$athlete_team_id'";
                                          $movement_query_execute = mysqli_query($conn, $movement_query);

                                          if (mysqli_num_rows($movement_query_execute) > 0) {
                                              while ($movementData = mysqli_fetch_assoc($movement_query_execute)) {
                                                  ?>
                                                  <option value="<?php echo $movementData["team_movement_id"]; ?>">
                                                      <?php echo $movementData["movement_name"]; ?>
                                                  </option>
                                                  <?php
                                              }
                                          } else {
                                              echo "<option disabled>No movements found for the athlete's team</option>";
                                          }
                                      } else {
                                          echo "<option disabled>Error fetching athlete's team</option>";
                                      }
                                  }
                                  ?>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="">Get Graph</label>
                              <br>
                              <button class="btn btn-sm btn-success" type="submit" name="assessment_choice">
                                Show Graph
                              </button>
                            </div>
                          </div>
                        </form>
                        <br>
                        <!-- Add a canvas element for the graph -->
                        <canvas id="myChart" width="400" height="200"></canvas>
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
if (isset($_POST['assessment_choice'])) {
    // Handle form submission
    $athlete_id = $_GET["athlete_id"];
    $assessment_date = $_POST['assessment_date'];
    $movement_id = $_POST['movement_name'];

    // Fetch assessment data for the selected athlete, movement, and date range (one week)
    $start_date = date('Y-m-d', strtotime($assessment_date . ' -7 days'));
    $end_date = date('Y-m-d', strtotime($assessment_date));

    $assessment_query = "SELECT assessment_date, numerical_value
                         FROM assessments
                         WHERE athlete_id = '$athlete_id'
                         AND team_movement_id = '$movement_id'
                         AND assessment_date BETWEEN '$start_date' AND '$end_date'
                         ORDER BY assessment_date";

    $assessment_query_execute = mysqli_query($conn, $assessment_query);

    $dates = [];
    $values = [];

    if (mysqli_num_rows($assessment_query_execute) > 0) {
        while ($assessmentData = mysqli_fetch_assoc($assessment_query_execute)) {
            $dates[] = $assessmentData['assessment_date'];
            $values[] = $assessmentData['numerical_value'];
        }
    } else {
        echo "No assessment data found for the selected athlete, movement, and date range.";
    }
}
?>


<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates, JSON_NUMERIC_CHECK); ?>,
        datasets: [{
            label: 'Numerical Values',
            data: <?php echo json_encode($values, JSON_NUMERIC_CHECK); ?>,
            fill: false, // Set the bar color with alpha transparency
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    parser: 'YYYY-MM-DD', // Format of your date data
                    tooltipFormat: 'll' // Format for tooltip display
                },
                title: {
                    display: true,
                    text: 'Date'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Numerical Value'
                }
            }
        },
        plugins: {
            zoom: {
                pan: {
                    enabled: true,
                    mode: 'x',
                    speed: 10
                },
                zoom: {
                    enabled: true,
                    mode: 'x',
                    speed: 0.1
                }
            }
        }
    }
});
</script>

<?php 
} else {
     header("Location: ../login-logout/login.php");
     exit();
}
?>