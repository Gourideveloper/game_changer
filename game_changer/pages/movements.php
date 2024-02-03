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
    <div class="modal fade" id="movementsModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Movement</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="code.php" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label class="form-label" for="movementName">Movement Name</label>
                <input type="text" class="form-control" id="movementName" name="movement_name" placeholder="Movement Name here..." required>
              </div>
              <div class="form-group">
                <label class="form-label" for="movementUnits">Movement Units</label>
                <select class="form-control" id="movementUnits" name="movement_units" required>
                  <option selected disabled>Choose Measurement Type</option>
                  <option value="lbs"> Pounds (lbs) </option>
                  <option value="s"> Seconds (s) </option>
                  <option value="in"> Inches (in) </option>
                </select>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="addMovement">Add</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Movements</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#movementsModal">+ Add Movement</button>
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
          <div class="col-md-2">
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <table id="movementsContainer" class="table table-bordered table-striped" style="text-align: center;">
                  <thead>
                    <tr>
                      <th>Sno</th>
                      <th hidden></th>
                      <th>Movement Name</th>
                      <th>Measurement Type</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody >
                    <?php
                      $query = "SELECT * FROM movements";
                      $query_execute = mysqli_query($conn, $query);

                      if(mysqli_num_rows($query_execute) > 0) {
                        $count = 0;
                        foreach ($query_execute as $data) {
                          $count += 1; 
                    ?>
                    <tr>
                      <td hidden> <?php echo $data["movement_id"]; ?> </td>
                      <td> <?php echo $count; ?> </td>
                      <td> <?php echo $data["movement_name"]; ?> </td>
                      <td> <?php echo $data["movement_units"]; ?> </td>
                      <td>
                        <button class="btn btn-sm btn-danger" onclick="deleteMovement(<?php echo $data['movement_id']; ?>)">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <?php 
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div> 
          <div class="col-md-2">
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>

<?php

	include('../includes/footer.php');

?>

<script>
  // Pagination and Search
  $(document).ready(function() {
    $('#movementsContainer').DataTable();

    // Live Editing table
    $('#movementsContainer').Tabledit({
      url: 'movementsTable.php',
      editButton: false,
      deleteButton: false,
      columns: {
        identifier: [0, 'id'],
        editable: [[2, 'movement_name'], [3, 'movement_units']]
      },
      onSuccess: function (data, textStatus, jqXHR) {
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


  // Deleting the row
  function deleteMovement(id) {
      // Show a confirmation alert before deleting
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this data!',
        icon: 'warning',
        buttons: {
          cancel: 'No, keep it',
          confirm: 'Yes, delete it!'
        },
        dangerMode: true,
      }).then((result) => {
        if (result === true) {
          // Make an AJAX request to delete the data from the database
          $.ajax({
            url: "movementsTable.php", 
            type: "POST",
            data: { action: "delete", id: id },
            success: function (response) {
              // Use SweetAlert to display a message based on the PHP session variable
              if (response == "success") {
                swal({
                  icon: 'success',
                  title: 'Success!',
                  text: 'Movement deleted successfully!!',
                }).then(() => {
                  // Refresh the page after the alert is closed
                  location.reload();
                });
              } else {
                swal({
                  icon: 'error',
                  title: 'Error',
                  text: 'Error in deleting the details.',
                }).then(() => {
                  // Refresh the page after the alert is closed
                  location.reload();
                });
              }
            }
        });
      } else {
        swal({
          icon: 'warning',
          title: 'Info',
          text: 'Deletion cancelled',
        });
      }
    });
   }

</script>


<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
 ?>