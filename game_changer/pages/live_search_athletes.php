<?php
    include('../database/db_conn.php');

    if (isset($_POST['searchKeyword'])) {
        $searchKeyword = mysqli_real_escape_string($conn, $_POST['searchKeyword']);
        if (!empty($searchKeyword)) {
            $query = "SELECT * FROM athletes WHERE athlete_name LIKE '%$searchKeyword%' ORDER BY athlete_id ASC";
        } else {
            $query = "SELECT * FROM athletes ORDER BY athlete_id ASC";
        }

        $query_execute = mysqli_query($conn, $query);

        if (mysqli_num_rows($query_execute) > 0) {
            $count = 0;
            foreach ($query_execute as $data) {
                $count += 1;
                // Output HTML for each athlete
                echo '<tr>
                        <td hidden>' . $data['athlete_id'] . '</td>
                        <td>' . $count . '</td>
                        <td class="editable" data-id="' . $data['athlete_id'] . '" data-field="athlete_name" contenteditable>
                            <a href="athlete_profile.php?athlete_id=' . $data['athlete_id'] . '">' . $data["athlete_name"] . '</a>
                        </td>
                        <td class="editable" data-id="' . $data['athlete_id'] . '" data-field="athlete_SID" contenteditable>
                            ' . $data["athlete_SID"] . '
                        </td>
                        <td class="editable" data-id="' . $data['athlete_id'] . '" data-field="athlete_age" contenteditable>
                            ' . $data["athlete_age"] . '
                        </td>
                        <td class="editable" data-id="' . $data['athlete_id'] . '" data-field="athlete_weight" contenteditable>
                            ' . $data["athlete_weight"] . '
                        </td>
                        <td class="editable" data-id="' . $data['athlete_id'] . '" data-field="athlete_height" contenteditable>
                            ' . $data["athlete_height"] . '
                        </td>
                        <td data-id="' . $data['athlete_id'] . '" data-field="athlete_status" contenteditable>
                            ' . $data["athlete_status"] . '
                        </td>';

                // Fetch and display team name using team_id
                $teamId = $data["athlete_team_id"];
                $teamQuery = "SELECT team_name FROM teams WHERE team_id = '$teamId'";
                $teamQuery_execute = mysqli_query($conn, $teamQuery);

                if (mysqli_num_rows($teamQuery_execute) > 0) {
                    foreach ($teamQuery_execute as $row) {
                        echo '<td>' . $row["team_name"] . '</td>';
                    }
                }

                echo '<td>
                        <button class="btn btn-danger btn-sm delete" data-id="' . $data['athlete_id'] . '"> Delete </button>
                    </td>
                    </tr>';
            }
        } else {
            echo "<tr><td colspan='8'>No athletes found</td></tr>";
        }
    }
?>
