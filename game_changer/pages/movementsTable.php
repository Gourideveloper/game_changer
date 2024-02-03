<?php

    // Include the database connection file
    include('../database/db_conn.php');

    $input = filter_input_array(INPUT_POST);

    if ($input['action'] == 'edit') {
        $update_field = '';
        if(isset($input['movement_name'])) {
            $update_field.= "movement_name='".trim($input['movement_name'])."'";
        } else if(isset($input['movement_units'])) {
            $update_field.= "movement_units='".trim($input['movement_units'])."'";
        }

        if($update_field && $input['id']) {
            try {
                $query = "UPDATE movements SET $update_field WHERE movement_id='" . $input['id'] . "'";
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
            } catch (Exception $e) {
                // Exception while updating data
                $response = [
                    'status' => 'error',
                    'message' => 'An error occurred while updating movement.',
                ];
                echo json_encode($response);
            }
        }
    }

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST["action"];
        $id = $_POST["id"];

        if ($action === "delete") {
            handleDelete($id);
        } else {
            echo "Invalid action";
        }
    }

    // Function to delete athlete details from the database
    function handleDelete($id) {
        global $conn; 

        $query = "DELETE FROM movements WHERE movement_id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "success";
        } else {
            echo "error";
        }
    }
?>
