<?php

// Include the database connection file
include('../database/db_conn.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    $id = $_POST["id"];

    // Check the action type and call the corresponding function
    if ($action === "update") {
        handleUpdate($id);
    } elseif ($action === "delete") {
        handleDelete($id);
    } else {
        echo "Invalid action";
    }
}

// Function to update athlete details in the database
function handleUpdate($id) {
    global $conn;

    $column = $_POST["column"];
    $value = $_POST["value"];

    $query = "UPDATE athletes SET $column = '$value' WHERE athlete_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
       echo "success";
    } else {
        echo "error";
    }
}

// Function to delete athlete details from the database
function handleDelete($id) {
    global $conn; 

    $query = "DELETE FROM athletes WHERE athlete_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
}

?>
