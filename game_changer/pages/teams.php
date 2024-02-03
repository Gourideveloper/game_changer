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
    <div class="modal fade" id="teamsModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Team</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="code.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label class="form-label" for="teamName">Team Name</label>
                <input type="text" class="form-control" id="teamName" name="team_name" placeholder="Team Name here..." required>
              </div>
              <div class="form-group">
                <label class="form-label" for="customFile">Team Image</label>
                <input type="file" class="form-control" id="imageFile" name="team_image" required />
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="addTeam">Add</button>
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
            <h1 class="m-0">Teams</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">

            <!-- SidebarSearch Form -->
            <form id="liveSearchForm" action="" method="POST">
              <div class="form-group">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                                aria-label="Search" name="teams_searchKeyword" id="liveSearchInput">
               </div>
            </form>
            
          </div>
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#teamsModal">+ Add Team</button>
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
        <div class="row" id="teamsContainer">
          <!-- small box -->
              <?php
                $query = "SELECT * FROM teams ORDER BY team_id ASC";
                $query_execute = mysqli_query($conn, $query);

                if(mysqli_num_rows($query_execute) > 0) {
                  while($data = mysqli_fetch_assoc($query_execute)) {
              ?>
              <!-- small box -->
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="icon" style="padding: 15px;">
                  <img class="info-box-icon bg-info elevation-1" src="../assets/img/teams/<?php echo $data['team_image']; ?>" style="width:100px; height:100px; border-radius:15%;">
                </div>

                <div class="inner">
                  <p class="text-lg"><?=$data['team_name']?></p>
                </div>
                
                <ul class="list-inline m-0 small-box-footer">
                  
                  <li class="list-inline-item">
                    <a href="edit_teams.php?team_id=<?php echo $data['team_id']; ?>" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit" name="edit_team"><i class="fa fa-edit"></i></a>
                  </li>

                  <li class="list-inline-item">
                    <form action="code.php" method="POST">
                      <input type="hidden" name="team_id" value="<?php echo $data['team_id']; ?>">
                      <input type="hidden" name="team_image" value="<?php echo $data['team_image']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm rounded-0">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </li>

                  <li class="list-inline-item">
                    <a href="team_info.php?team_id=<?php echo $data['team_id']; ?>" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </li>

                </ul>
                
              </div>
            </div>
            <!-- ./col -->
            <?php  
                }
              } else {
                echo "No teams found";
              }
            ?>
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
        // Function to load teams
        function loadTeams(teams_searchKeyword = '') {
            $.ajax({
                type: 'POST',
                url: 'live_search.php',
                data: { teams_searchKeyword: teams_searchKeyword },
                success: function (response) {
                    $('#teamsContainer').html(response);
                }
            });
        }

        // Live search
        $('#liveSearchInput').on('input', function () {
            var teams_searchKeyword = $(this).val();
            loadTeams(teams_searchKeyword);
        });

        // Initial load
        loadTeams();
    });
</script>

<?php 
} else{
     header("Location: ../login-logout/login.php");
     exit();
}
 ?>