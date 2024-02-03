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
              <div class="card-header">
                <h3>Select the requirements</h3>
              </div>
              <div class="card-body">
                <form action="assessments.php" method="POST">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="assessmentDate">Choose Date</label>
                      <input type="date" class="form-control" name="assessment_date">
                    </div>
                    <div class="col-md-4">
                      <label for="teamName">Choose Team</label>
                      <select id="teamName" class="form-control" name="team_name">
                        <option selected disabled>Choose Team</option>
                        <?php
                            $teamQuery = "SELECT * FROM teams ORDER BY team_id ASC";
                            $teamQuery_execute = mysqli_query($conn, $teamQuery);

                            if(mysqli_num_rows($teamQuery_execute)) {
                              while($teamData = mysqli_fetch_assoc($teamQuery_execute)) {
                        ?>
                        <option value="<?php echo $teamData['team_id']; ?>">
                          <?php echo $teamData['team_name']; ?>
                        </option>
                        <?php
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-4">
                      <button class="btn btn-sm btn-success" type="submit" name="assessment_choice">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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


<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
?>