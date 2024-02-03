<?php
    include('../database/db_conn.php');

    // Live Search for teams
    if (isset($_POST['teams_searchKeyword'])) {
        $searchKeyword = mysqli_real_escape_string($conn, $_POST['teams_searchKeyword']);
        if (!empty($searchKeyword)) {
            $query = "SELECT * FROM teams WHERE team_name LIKE '%$searchKeyword%' ORDER BY team_id ASC";
        } else {
            $query = "SELECT * FROM teams ORDER BY team_id ASC";
        }

        $query_execute = mysqli_query($conn, $query);

        if (mysqli_num_rows($query_execute) > 0) {
            while ($data = mysqli_fetch_assoc($query_execute)) {
                echo '<div class="col-lg-3 col-6">
                          <div class="small-box bg-info">
                            <div class="icon" style="padding: 15px;">
                              <img class="info-box-icon bg-info elevation-1" src="../assets/img/teams/'.$data['team_image'].'" style="width:100px; height:100px; border-radius:15%;">
                            </div>

                            <div class="inner">
                              <p class="text-lg">'.$data['team_name'].'</p>
                            </div>
                            
                            <ul class="list-inline m-0 small-box-footer">
                              
                              <li class="list-inline-item">
                                <a href="edit_teams.php?team_id='.$data['team_id'].'" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit" name="edit_team"><i class="fa fa-edit"></i></a>
                              </li>

                              <li class="list-inline-item">
                                <form action="code.php" method="POST">
                                  <input type="hidden" name="team_id" value="'.$data['team_id'].'">
                                  <input type="hidden" name="team_image" value="'.$data['team_image'].'">
                                  <button type="submit" class="btn btn-danger btn-sm rounded-0">
                                    <i class="fa fa-trash"></i>
                                  </button>
                                </form>
                              </li>

                              <li class="list-inline-item">
                                <a href="team_info.php?team_id='.$data['team_id'].'" class="small-box-footer text-white">More info <i class="fas fa-arrow-circle-right"></i></a>
                              </li>

                            </ul>
                            
                          </div>
                        </div>
                        <!-- ./col -->';
            }
        } else {
            echo "No teams found";
        }
    }
?>
