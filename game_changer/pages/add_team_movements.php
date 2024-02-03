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
            <h1 class="m-0">Add Movements to Team</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <?php
                  if(isset($_GET['team_id'])) {
                    $team_id = $_GET['team_id'];

                    $query = "SELECT * FROM teams WHERE team_id = '$team_id'";
                    $query_execute = mysqli_query($conn, $query);

                    if(mysqli_num_rows($query_execute) > 0) {
                      while($data = mysqli_fetch_assoc($query_execute)) {
                ?>
                <a href="team_info.php?team_id=<?php echo $data["team_id"]; ?>" class="btn btn-md btn-info">Back</a>
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <?php 
                    if(isset($_GET['team_id'])) {
                      $team_id = $_GET['team_id'];
                  ?>
                  <input type="hidden" name="team_id" value="<?php echo $team_id; ?> ">
                  <?php 
                    }
                  ?>
                  <div class="row">
                      <?php 
                      $query = "SELECT * FROM movements";
                      $query_execute = mysqli_query($conn, $query);

                      if (mysqli_num_rows($query_execute) > 0) {
                          while ($data = mysqli_fetch_assoc($query_execute)) {
                              // Check if the movement is associated with the team
                              $team_movement_query = "SELECT * FROM team_movements WHERE team_id = '$team_id' AND movement_id = '{$data['movement_id']}'";
                              $team_movement_result = mysqli_query($conn, $team_movement_query);

                              $is_associated = mysqli_num_rows($team_movement_result) > 0;

                              ?>
                              <div class="col-md-3">
                                  <!-- Sample Movement Cell -->
                                  <div style="border: 1px solid #ddd; padding: 10px; margin: 10px;
                                              border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                              display: flex; align-items: center; justify-content: space-between;">
                                      <div style="flex-grow: 1;">
                                          <p><strong><?php echo $data["movement_name"] ?></strong></p>
                                      </div>
                                      <div style="display: flex; align-items: center;">
                                          <div style="border-left: 1px solid #ddd; height: 30px; margin: 0 10px;"></div>
                                          <button type="button" class="btn btn-sm rounded-0 btn-check <?php echo $is_associated ? 'btn-success' : 'btn-primary'; ?>" data-movement-id="<?php echo $data['movement_id']; ?>">
                                              <i class="fa fa-check"></i>
                                          </button> 
                                      </div>
                                  </div>
                              </div>
                      <?php 
                          }
                      }
                      ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-success float-sm-right" id="btnDone">Done</button>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>

<?php

	include('../includes/footer.php');

?>

<script>
  $(document).ready(function () {
    // Function to toggle button color
    $('.btn-check').on('click', function () {
      $(this).toggleClass('btn-primary btn-success');
    });

    // Function to get movement_ids of green-colored buttons
    $('#btnDone').on('click', function () {
      var greenButtons = $('.btn-success');
      var movementIds = [];

      greenButtons.each(function () {
        var movementId = $(this).data('movement-id');
        movementIds.push(movementId);
      });

      // Make an AJAX request to add team_movements
      var team_id = $('input[name="team_id"]').val();

      $.ajax({
        type: 'POST',
        url: 'code.php',
        data: { team_id: team_id, movement_ids: movementIds },
        dataType: 'json',
        success: function (response) {
          console.log(response);

          if (response.status === 'success') {
            swal({
              icon: 'success',
              title: 'Success!',
              text: 'Movements are successfully added to Team',
            }).then(() => {
              // Reload the page or update the table as needed
              location.reload();
            });
          } else {
            swal({
              icon: 'error',
              title: 'Error!',
              text: 'Error in adding movements to the team',
            }).then(() => {
              // Reload the page or update the table as needed
              location.reload();
            });
          }
        },
        error: function (error) {
          console.error('AJAX request failed:', error);
          swal({
            icon: 'error',
            title: 'Error!',
            text: 'Request Failed',
          }).then(() => {
              // Reload the page or update the table as needed
              location.reload();
          });
        }
      });
    });
  });
</script>

<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
 ?>