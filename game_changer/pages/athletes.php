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
            <h1 class="m-0">Athletes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="add_athletes.php" class="btn btn-md btn-success">+ Add Athletes</a>
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
            <!-- SidebarSearch Form -->
            <form id="liveSearchForm" action="" method="POST">
              <div class="form-group">
                <label for="liveSearchInput">Search by Athlete Name</label>
                <input class="form-control form-control-sidebar" type="search" placeholder="Search here..." aria-label="Search" name="searchKeyword" id="liveSearchInput">
              </div>
            </form>
          </div>

          <!-- Filter by Athlete Height -->
          <!-- <div class="col-sm-2">
            <div class="form-group">
              <label for="filterHeight">Filter by Height</label>
              <select class="form-control" id="filterHeight">
                <option value="">All</option>
                <option value="Short">Short</option>
                <option value="Tall">Tall</option>
              </select>
            </div>
          </div> -->    

          <!-- Filter by Athlete Age -->
          <!-- <div class="col-sm-2">
            <div class="form-group">
              <label for="filterAge">Filter by Age</label>
              <select class="form-control" id="filterAge">
                  <option value="">All</option>
                  <option value="Young">Young</option>
                  <option value="Middle-aged">Middle-aged</option>
                  <option value="Senior">Senior</option>
              </select>
            </div>
          </div> -->

          <!-- Filter by Athlete Weight -->
          <!-- <div class="col-sm-2">
            <div class="form-group">
              <label for="filterWeight">Filter by Weight</label>
              <select class="form-control" id="filterWeight">
                <option value="">All</option>
                <option value="Light">Light</option>
                <option value="Heavy">Heavy</option>
              </select>
            </div>
          </div> -->

          <!-- Filter by Athlete Status -->
          <!-- <div class="col-sm-2">
            <div class="form-group">
              <label for="filterStatus">Filter by Status</label>
                <select class="form-control" id="filterStatus">
                  <option value="">All</option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
            </div>
          </div> -->
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sno</th>
                    <th>Athlete Name</th>
                    <th>Athlete 919#</th>
                    <th>Athlete Age (in years)</th>
                    <th>Athlete Weight (in lbs)</th>
                    <th>Athlete Height</th>
                    <th>Athlete Status</th>
                    <th>Athlete Team</th>
                  </tr>
                  </thead>
                  <tbody>

                    <!-- Displaying all the athlete details -->
                    <?php 
                        $query = "SELECT * FROM athletes";
                        $query_execute = mysqli_query($conn, $query);
                        $count = 0;

                        if(mysqli_num_rows($query_execute) > 0) {
                          foreach ($query_execute as $data) {
                            $count += 1;
                    ?>
                  <tr>
                    <td hidden><?php echo $data['athlete_id']; ?></td>
                    <td><?php echo $count; ?></td>
                    <td class="editable" data-id="<?php echo $data['athlete_id']; ?>" data-field="athlete_name" contenteditable>
                      <a href="athlete_profile.php?athlete_id=<?php echo $data['athlete_id']; ?>"><?php echo $data["athlete_name"]; ?></a>
                    </td>
                    <td class="editable" data-id="<?php echo $data['athlete_id']; ?>" data-field="athlete_SID" contenteditable>
                      <?php echo $data["athlete_SID"]; ?>
                    </td>
                    <td class="editable" data-id="<?php echo $data['athlete_id']; ?>" data-field="athlete_age" contenteditable>
                      <?php echo $data["athlete_age"]; ?> 
                    </td>
                    <td class="editable" data-id="<?php echo $data['athlete_id']; ?>" data-field="athlete_weight" contenteditable>
                      <?php echo $data["athlete_weight"]; ?>
                    </td>
                    <td class="editable" data-id="<?php echo $data['athlete_id']; ?>" data-field="athlete_height" contenteditable>
                      <?php echo $data["athlete_height"]; ?>
                    </td>
                    <td  data-id="<?php echo $data['athlete_id']; ?>" data-field="athlete_status" contenteditable>
                      <?php echo $data["athlete_status"]; ?>
                    </td>

                    <!-- Fetch and display team name using team_id -->
                    <?php 
                      $teamId = $data["athlete_team_id"];
                      $teamQuery = "SELECT team_name FROM teams WHERE team_id = '$teamId'";
                      $teamQuery_execute = mysqli_query($conn, $teamQuery);

                      if(mysqli_num_rows($teamQuery_execute) > 0) {
                        foreach ($teamQuery_execute as $row) {
                    ?>  
                    <td>
                      <?php echo $row["team_name"]; ?>
                    </td>
                    <?php
                        }
                      }
                    ?>
                    <td>
                      <button class="btn btn-danger btn-sm delete" data-id="<?php echo $data['athlete_id']; ?>"> Delete </button>
                    </td>
                  </tr>
                  <?php
                      }
                    }
                  ?>
                  </tbody>
                </table>
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

<script>
$(document).ready(function () {
  
  function loadAthletes(searchKeyword = '') {
    $.ajax({
      type: 'POST',
      url: 'live_search_athletes.php', 
      data: { searchKeyword: searchKeyword },
      success: function (response) {
        $('#example1 tbody').html(response);
      }
    });
  }

  // Live search
  $('#liveSearchInput').on('input', function () {
    var searchKeyword = $(this).val();
    loadAthletes(searchKeyword);
  });

  // Initial load
  loadAthletes();

  // Navigating to athlete profile
  $("table tbody").on("click touchstart", "td[data-field='athlete_name'] a", function (event) {
    event.preventDefault();
    console.log("Link clicked");

    // Extract athlete ID from the link
    var athleteId = $(this).attr("href").split("=")[1];

    // Simulate navigation to the athlete profile page
    var profileUrl = "athlete_profile.php?athlete_id=" + athleteId;
    window.location.href = profileUrl;
  });

  // Enabling live editing for required columns
  $("table tbody").on("dblclick", "td[data-field]", function () {
    var originalContent = $(this).text();
    var column = $(this).data("field");
    var id = $(this).closest("tr").find("td[data-id]").data("id");

    // Replacing the content with an input field
    $(this).html("<input type='text' class='form-control' value='" + originalContent + "' />");

    // Focus on the input field
    $(this).find("input").focus();

    // Handle blur event (when the user clicks outside the input field)
    $(this).find("input").on("blur", function () {
      var newContent = $(this).val();

      // Check if the content has changed
      if (newContent !== originalContent) {
        // Make an AJAX request to update the data in the database
        $.ajax({
          url: "athletesTable.php", 
          type: "POST",
          data: { action: "update", id: id, column: column, value: newContent },
          success: function (response) {

          // Use SweetAlert to display a message based on the PHP session variable
          if (response == "success") {
            swal({
              icon: 'success',
              title: 'Success!',
              text: 'Athlete details updated successfully!!',
              }).then(() => {
                // Refresh the page after the alert is closed
                location.reload();
              });
          } else {
              swal({
                icon: 'error',
                title: 'Error',
                text: 'Error in updating the details.',
              }).then(() => {
                // Refresh the page after the alert is closed
                location.reload();
              });
            }
          }
        });
      }

      // Replace the input field with the updated content
      $(this).closest("td").text(newContent);
    });
  });

  
  // Handling delete button click
  $("table tbody").on("click", "button.delete", function () {
      var id = $(this).closest("tr").find("td[data-id]").data("id");

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
        if (result !== null && result.isConfirmed) {
          // Make an AJAX request to delete the data from the database
          $.ajax({
            url: "athletesTable.php", // Replace with the actual PHP script to handle the delete
            type: "POST",
            data: { action: "delete", id: id },
            success: function (response) {
              // Use SweetAlert to display a message based on the PHP session variable
              if (response == "success") {
                swal({
                  icon: 'success',
                  title: 'Success!',
                  text: 'Athlete details deleted successfully!!',
                }).then(() => {
                  // Refresh the page after the alert is closed
                  location.reload();
                });

                // Remove the row from the table on successful delete
                $("table tbody tr").has("td:contains('" + id + "')").remove();
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
  });
});      
      
</script>


<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
?>