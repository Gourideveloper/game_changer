<?php

    // Include the database connection file
    include('../database/db_conn.php');

    $input = filter_input_array(INPUT_POST);

    if ($input['action'] == 'edit') {
        // Extracting the athlete_id, team_id and date
        $id_values = explode('+', $input['id']);
        $athlete_id = $id_values[0];
        $team_id = $id_values[1];
        $assessment_date = date('Y-m-d', strtotime($id_values[2]));


        $query = "INSERT INTO assessments (athlete_id, team_movement_id, assessment_date, numerical_value) VALUES ($athlete_id, $team_id, '$assessment_date', $update_fields)";
        $query_execute = mysqli_query($conn, $query);

        if ($query_execute) {
            // Data updated successfully
            $response = [
                'status' => 'success',
                'message' => 'Movement updated successfully!',
            ];
            echo json_encode($response);
        } else {
            // Failed to update data
            $response = [
            'status' => 'error',
            'message' => 'Failed to update movement.',
            ];
            echo json_encode($response);
        }

        // $query = "SELECT movements.movement_name
        //       FROM movements
        //       INNER JOIN team_movements ON movements.movement_id = team_movements.movement_id
        //       WHERE team_movements.team_id = '$team_id'";
        // $query_execute = mysqli_query($conn, $query);

        // $update_field = '';

        // if ($query_execute) {
        //     $movement_names = array();

        //     while ($row = mysqli_fetch_assoc($query_execute)) {
        //         if(isset($input[$row['movement_name']])) {
        //             $update_field.= trim($input['movement_name'])

        //             $assessment_query = "INSERT INTO assessments (athlete_id, team_movement_id, assessment_date, numerical_value) VALUES ($athlete_id, $row['team_movemen_id'], $assessment_date, $update_field)";
        //             $execute = mysqli_query($conn, $assessment_query);

        //             if ($execute) {
        //                 // Data updated successfully
        //                 $response = [
        //                     'status' => 'success',
        //                     'message' => 'Movement updated successfully!',
        //                 ];
        //                 echo json_encode($response);
        //             } else {
        //                 // Failed to update data
        //                 $response = [
        //                     'status' => 'error',
        //                     'message' => 'Failed to update movement.',
        //                 ];
        //                 echo json_encode($response);
        //             }
        //         }
        //     }

        // } else {
        //     // Handle the query execution error
        //     echo "Error executing query: " . mysqli_error($conn);
        // }
    }

    
?>
