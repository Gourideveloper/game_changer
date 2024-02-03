<?php

	session_start(); 
	include("../database/db_conn.php"); 


	// Adding new team
	if(isset($_POST["addTeam"]) && isset($_FILES["team_image"])) {

		// Allowed file extensions
    	$allowedExtensions = ["jpg", "jpeg", "png"];

		// Retrieving team details from the form
		$teamName = $_POST["team_name"];

		// Getting the image file
		$file = $_FILES["team_image"];

		// Checking file extension
        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            $_SESSION["status"] = "Invalid file extension. Please upload a JPG, JPEG, or PNG file.";
			$_SESSION["status_code"] = "error";
			header("Location: teams.php");
        }

        // Checking file size
        $maxFileSize = 12500; // in kilobytes
        if ($file["size"] > $maxFileSize * 1024) {
        	$_SESSION["status"] = "File size exceeds the maximum allowed size of $maxFileSize KB.";
			$_SESSION["status_code"] = "error";
			header("Location: teams.php");
        }

        // Using team name as the image name
        $imageName = $teamName . "." . $fileExtension;

        // Directory to store the images
        $uploadDirectory = "../assets/img/teams/";

        // Handling the Exceptions
        try {

        	// Query to insert
        	$query = "INSERT INTO teams (team_name, team_image) VALUES ('$teamName', '$imageName')";
	        $query_execute = mysqli_query($conn, $query);
			
			// If insertion is successful
			if($query_execute) {

				// Move the uploaded file to the specified directory
	            if (move_uploaded_file($file["tmp_name"], $uploadDirectory.$imageName)) {
	                $_SESSION["status"] = "New team is added successfully!!";
					$_SESSION["status_code"] = "success";
					header("Location: teams.php");
	            } else {
	                $_SESSION["status"] = "Error uploading the image, but new team is added successfully.";
					$_SESSION["status_code"] = "warning";
					header("Location: teams.php");
	            }
			} else {
				$_SESSION["status"] = "Creating new team failed";
				$_SESSION["status_code"] = "warning";
				header("Location: teams.php");
			}
        } catch(Exception $e) {
        	$_SESSION["status"] = "A team is already registered with same name.";
			$_SESSION["status_code"] = "error";
			header("Location: teams.php");
        }
	}



	// Edit or Update a team
	if(isset($_POST["updateTeam"])) {

		// Retrieving team details from the form
		$team_id = $_POST["team_id"];
		$teamName = $_POST["team_name"];

		// Checking if a new image is selected
	    if (isset($_FILES["team_image"]) && $_FILES["team_image"]["error"] == 0) {

	        // Allowed file extensions
	        $allowedExtensions = ["jpg", "jpeg", "png"];

	        $file = $_FILES["team_image"];

	        // Checking file extension
	        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
	        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
	        	$_SESSION["status"] = "Invalid file extension. Please upload a JPG, JPEG, or PNG file.";
				$_SESSION["status_code"] = "error";
				header("Location: teams.php");
	        }

	        // Checking file size
	        $maxFileSize = 12500; // in kilobytes
	        if ($file["size"] > $maxFileSize * 1024) {
	            $_SESSION["status"] = "File size exceeds the maximum allowed size of $maxFileSize KB.";
				$_SESSION["status_code"] = "error";
				header("Location: teams.php");
	        }

	        // Using the team name as image name
	        $imageName = $teamName. "." . $fileExtension;

	        // Uploading the images to directory
	        $uploadDirectory = "../assets/img/teams/";

	        // Getting the old image path from the database
        	$oldImage_query = "SELECT team_image FROM teams WHERE team_id='$team_id'";
        	$oldImage_query_execute = mysqli_query($conn, $oldImage_query);

        	// If any results
        	if (mysqli_num_rows($oldImage_query_execute) > 0) {
	            while($row = mysqli_fetch_assoc($oldImage_query_execute)) {
	            	$oldImagePath = $row["team_image"];

	            	try {
	            		// Query to update
		            	$query = "UPDATE teams SET team_name='$teamName', team_image='$imageName' WHERE team_id='$team_id'";
		            	$query_execute = mysqli_query($conn, $query);

		            	// If updation is successful
		            	if($query_execute) {

		            		// Unlink or delete the old image file
			                if (file_exists("../assets/img/teams/".$oldImagePath)) {
			                    unlink("../assets/img/teams/".$oldImagePath);
			                }

			                // Move the new uploaded image to the specified directory
			                if (move_uploaded_file($file["tmp_name"], $uploadDirectory.$imageName)) {
			                	$_SESSION["status"] = "Team is updated successfully!!";
								$_SESSION["status_code"] = "success";
								header("Location: teams.php"); 
			                } else {
			                    $_SESSION["status"] = "Error uploading the image, but team is updated successfully.";
								$_SESSION["status_code"] = "success";
								header("Location: teams.php");
			                }
		            	} else {
		            		$_SESSION["status"] = "Updating team failed";
							$_SESSION["status_code"] = "warning";
							header("Location: teams.php");
		            	}
	            	} catch(Exception $e) {
	            		$_SESSION["status"] = "A team is already registered with same name.";
						$_SESSION["status_code"] = "error";
						header("Location: teams.php");
	            	}
	            }
	        }
	    } else {

	    	// No new image selected, only update team name

	    	// Handling the exceptions
	    	try {
	    		// Query to execute
		        $query = "UPDATE teams SET team_name='$teamName' WHERE team_id='$team_id'";
		        $query_execute = mysqli_query($conn, $query);

		        if($query_execute) {
		        	$_SESSION["status"] = "Team is updated successfully!!";
		        	$_SESSION["status_code"] = "success";
		        	header("Location: teams.php");
		        } else {
		        	$_SESSION["status"] = "Updating team failed";
		        	$_SESSION["status_code"] = "warning";
		        	header("Location: teams.php");
		        }
	    	} catch(Exception $e) {
	    		$_SESSION["status"] = "A team is already registered with the same name.";
	    		$_SESSION["status_code"] = "error";
	    		header("Location: teams.php");
	    	}
	    }      	
	}

	// Delete a team
	if(isset($_POST["team_id"]) && isset($_POST["team_image"])) {
		
		// Retriving team details
		$team_id = $_POST["team_id"];
		$team_image = $_POST["team_image"];

		// Query to execute
		$query = "DELETE FROM teams WHERE team_id = '$team_id'";
		$query_execute = mysqli_query($conn, $query);

		// If deletion is successful
		if($query_execute) {

			// Delete the image
			unlink("../assets/img/teams/".$team_image);

			$_SESSION["status"] = "Team deleted successfully.";
			$_SESSION["status_code"] = "success";
			header("Location: teams.php");
		} else {
			$_SESSION["status"] = "Unknown error occurred.";
			$_SESSION["status_code"] = "error";
			header("Location: teams.php");
		}

	}

	// Adding an athlete for a team
	if(isset($_POST["addAthlete"])) {

		// Retriving athlete details from the form
		$athlete_name = $_POST["athlete_name"];
		$athlete_SID = $_POST["athlete_SID"];
		$athlete_age = $_POST["athlete_age"];
		$athlete_height = $_POST["athlete_height"];
		$athlete_weight = $_POST["athlete_weight"];
		$athlete_status = $_POST["athlete_status"];
		$athlete_team_id = $_POST["athlete_team"];

		// Check if 919# is valid or not
	    if (!preg_match("/^919\d{6}$/", $athlete_SID)) {
	    	$_SESSION["status"] = "Invalid 919# number of athlete.";
			$_SESSION["status_code"] = "error";
			header("Location: team_info.php?team_id=".$athlete_team_id);	    }

	    // Uploading the images to directory
    	$uploadDirectory = "../assets/img/athlete_images/";

    	// Checking if an athlete image is selected for upload
	    if (isset($_FILES["athlete_image"])) {
	        $file = $_FILES["athlete_image"];

	        // Allowed extensions 
	        $allowedExtensions = ["jpg", "jpeg", "png"];

	        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);

	        // Checking file type
	        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
	            $_SESSION["status"] = "Invalid file extension. Please upload a JPG, JPEG, or PNG file.";
				$_SESSION["status_code"] = "error";
				header("Location: team_info.php?team_id=".$athlete_team_id);
	        }

	        // Checking file size
	        $maxFileSize = 12500; // in kilobytes
	        if ($file["size"] > $maxFileSize * 1024) {
	        	$_SESSION["status"] = "File size exceeds the maximum allowed size of $maxFileSize KB.";
				$_SESSION["status_code"] = "error";
				header("Location: team_info.php?team_id=".$athlete_team_id);
	        }

	        // Using 919# as the image name
        	$imageName = $athlete_SID. "." . $fileExtension;

        	// Handling the exceptions
        	try {

        		// Query to execute
        		$query = "INSERT INTO athletes (athlete_name, athlete_SID, athlete_age, athlete_height, athlete_weight, athlete_status, athlete_team_id, athlete_image) 
                VALUES ('$athlete_name', '$athlete_SID', '$athlete_age', '$athlete_height', '$athlete_weight', '$athlete_status', '$athlete_team_id', '$imageName')";
                $query_execute = mysqli_query($conn, $query);

                // If insertion is successful
                if($query_execute) {

                	// Move the uploaded file to the specified directory
		            if (move_uploaded_file($file["tmp_name"], $uploadDirectory.$imageName)) {
		                $_SESSION["status"] = "Athlete details added successfully!!";
						$_SESSION["status_code"] = "success";
						header("Location: team_info.php?team_id=".$athlete_team_id);
		            } else {
		                $_SESSION["status"] = "Error uploading the image, but athlete details are added successfully.";
						$_SESSION["status_code"] = "warning";
						header("Location: team_info.php?team_id=".$athlete_team_id);
		            }
                } else {
					$_SESSION["status"] = "Adding athletes failed";
					$_SESSION["status_code"] = "warning";
					header("Location: team_info.php?team_id=".$athlete_team_id);
				}
	        } catch(Exception $e) {
	        	$_SESSION["status"] = "An athlete is already registered with same 919#.";
				$_SESSION["status_code"] = "error";
				header("Location: team_info.php?team_id=".$athlete_team_id);
	        }
	    }
	}

	// Edit or Update an athlete details
	if(isset($_POST["updateAthlete"])) {

		// Retrieving athlete details from the form
		$athlete_id = $_POST["athlete_id"];
		$athlete_name = $_POST["athlete_name"];
		$athlete_SID = $_POST["athlete_SID"];
		$athlete_age = $_POST["athlete_age"];
		$athlete_height = $_POST["athlete_height"];
		$athlete_weight = $_POST["athlete_weight"];
		$athlete_status = $_POST["athlete_status"];
		$athlete_team_id = $_POST["athlete_team"];

		// Checking if a new image is selected
	    if (isset($_FILES["athlete_image"]) && $_FILES["athlete_image"]["error"] == 0) {

	        // Allowed file extensions
	        $allowedExtensions = ["jpg", "jpeg", "png"];

	        $file = $_FILES["athlete_image"];

	        // Checking file extension
	        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
	        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
	        	$_SESSION["status"] = "Invalid file extension. Please upload a JPG, JPEG, or PNG file.";
				$_SESSION["status_code"] = "error";
				header("Location: team_info.php?team_id=".$athlete_team_id);
	        }

	        // Checking file size
	        $maxFileSize = 12500; // in kilobytes
	        if ($file["size"] > $maxFileSize * 1024) {
	            $_SESSION["status"] = "File size exceeds the maximum allowed size of $maxFileSize KB.";
				$_SESSION["status_code"] = "error";
				header("Location: team_info.php?team_id=".$athlete_team_id);
	        }

	        // Using the team name as image name
	        $imageName = $athlete_SID. "." . $fileExtension;

	        // Uploading the images to directory
	        $uploadDirectory = "../assets/img/athlete_images/";

	        // Getting the old image path from the database
        	$oldImage_query = "SELECT athlete_image FROM athletes WHERE athlete_id='$athlete_id'";
        	$oldImage_query_execute = mysqli_query($conn, $oldImage_query);

        	// If any results
        	if (mysqli_num_rows($oldImage_query_execute) > 0) {
	            while($row = mysqli_fetch_assoc($oldImage_query_execute)) {
	            	$oldImagePath = $row["athlete_image"];

	            	try {
	            		// Query to update
		            	$query = "UPDATE athletes SET athlete_name='$athlete_name', athlete_image='$imageName', athlete_SID='$athlete_SID', athlete_status='$athlete_status', athlete_weight='$athlete_weight', athlete_height='$athlete_height', athlete_age='$athlete_age', athlete_team_id='$athlete_team_id' WHERE athlete_id='$athlete_id'";
		            	$query_execute = mysqli_query($conn, $query);

		            	// If updation is successful
		            	if($query_execute) {

		            		// Unlink or delete the old image file
			                if (file_exists("../assets/img/athlete_images/".$oldImagePath)) {
			                    unlink("../assets/img/athlete_images/".$oldImagePath);
			                }

			                // Move the new uploaded image to the specified directory
			                if (move_uploaded_file($file["tmp_name"], $uploadDirectory.$imageName)) {
			                	$_SESSION["status"] = "Athlete details are updated successfully!!";
								$_SESSION["status_code"] = "success";
								header("Location: team_info.php?team_id=".$athlete_team_id); 
			                } else {
			                    $_SESSION["status"] = "Error uploading the image, but athlete details are updated successfully.";
								$_SESSION["status_code"] = "success";
								header("Location: team_info.php?team_id=".$athlete_team_id);
			                }
		            	} else {
		            		$_SESSION["status"] = "Updating athlete details failed";
							$_SESSION["status_code"] = "warning";
							header("Location: team_info.php?team_id=".$athlete_team_id);
		            	}
	            	} catch(Exception $e) {
	            		$_SESSION["status"] = "An athlete is already registered with same 919#.";
						$_SESSION["status_code"] = "error";
						header("Location: team_info.php?team_id=".$athlete_team_id);
	            	}
	            }
	        }
	    } else {

	    	// No new image selected, only update team name

	    	// Handling the exceptions
	    	try {
	    		// Query to execute
		        $query = "UPDATE athletes SET athlete_name='$athlete_name', athlete_SID='$athlete_SID', athlete_status='$athlete_status', athlete_weight='$athlete_weight', athlete_height='$athlete_height', athlete_age='$athlete_age', athlete_team_id='$athlete_team_id' WHERE athlete_id='$athlete_id'";
		        $query_execute = mysqli_query($conn, $query);

		        if($query_execute) {
		        	$_SESSION["status"] = "Athlete details are updated successfully!!";
		        	$_SESSION["status_code"] = "success";
		        	header("Location: team_info.php?team_id=".$athlete_team_id);
		        } else {
		        	$_SESSION["status"] = "Updating athlete details failed";
		        	$_SESSION["status_code"] = "warning";
		        	header("Location: team_info.php?team_id=".$athlete_team_id);
		        }
	    	} catch(Exception $e) {
	    		$_SESSION["status"] = "An athlete is already registered with the same 919#.";
	    		$_SESSION["status_code"] = "error";
	    		header("Location: team_info.php?team_id=".$athlete_team_id);
	    	}
	    }      	
	}


	// Deleting an athlete from a team
	if(isset($_POST['athlete_id']) && isset($_POST['athlete_image'])) {

		// Retriving athletes details
		$athlete_id = $_POST["athlete_id"];
		$athlete_image = $_POST["athlete_image"];
		$athlete_team_id = $_POST["athlete_team_id"];

		// Query to execute
		$query = "DELETE FROM athletes WHERE athlete_id = '$athlete_id'";
		$query_execute = mysqli_query($conn, $query);

		// If deletion is successful
		if($query_execute) {

			// Delete the image
			unlink("../assets/img/athlete_images/".$athlete_image);

			$_SESSION["status"] = "Athlete details deleted successfully.";
			$_SESSION["status_code"] = "success";
			header("Location: team_info.php?team_id=".$athlete_team_id);
		} else {
			$_SESSION["status"] = "Unknown error occurred.";
			$_SESSION["status_code"] = "error";
			header("Location: team_info.php?team_id=".$athlete_team_id);
		}
	}


	// Adding a movement for a team
	if(isset($_POST['addMovement'])) {

		// Retriving movement details
		$movement_name = $_POST["movement_name"];
		$movement_units = $_POST["movement_units"];

		// Handling the exceptions
	    try {

	    	// Query to execute
		    $query = "INSERT INTO movements (movement_name, movement_units) VALUES ('$movement_name', '$movement_units')";
		    $query_execute = mysqli_query($conn, $query);

		    if($query_execute) {
		        $_SESSION["status"] = "Movement is added successfully!!";
		        $_SESSION["status_code"] = "success";
		        header("Location: movements.php");
		    } else {
		        $_SESSION["status"] = "Adding Movement failed";
		        $_SESSION["status_code"] = "warning";
		        header("Location: movements.php");
		    }
	    } catch(Exception $e) {
	    	$_SESSION["status"] = "A movement is already registered with the same name.";
	    	$_SESSION["status_code"] = "error";
	   		header("Location: movements.php");
	    }		           
	}

	
	// Add movements for a particular team
	if (isset($_POST['team_id']) && isset($_POST['movement_ids'])) {
	    $team_id = $_POST['team_id'];
	    $movement_ids = $_POST['movement_ids'];

	    // Delete existing rows associated with the team
	    $delete_query = "DELETE FROM team_movements WHERE team_id = '$team_id'";
	    $delete_query_execute = mysqli_query($conn, $delete_query);

	    if (!$delete_query_execute) {
	        echo "Deleted";
	    }

	    // Insert new rows into the team_movements table
	    foreach ($movement_ids as $movement_id) {
	        $insert_query = "INSERT INTO team_movements (team_id, movement_id) VALUES ('$team_id', '$movement_id')";
	        $insert_query_execute = mysqli_query($conn, $insert_query);

	        if (!$insert_query_execute) {
	            echo json_encode(['status' => 'error', 'message' => 'Error in adding team movements']);
	            exit();
	        }
	    }

	    echo json_encode(['status' => 'success', 'message' => 'Team movements updated successfully']);
	} else {
	    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
	}

	// Delete a particular movement for a team
	if (isset($_POST['team_id']) && isset($_POST['movement_id'])) {

		// Get the values
		$team_id = $_POST['team_id'];
	    $movement_id = $_POST['movement_id'];

	    // Query
	    $query = "DELETE FROM team_movements WHERE team_id = '$team_id' AND movement_id ='$movement_id' ";
	    $query_execute = mysqli_query($conn, $query);

	    if($query_execute) {
	    	$_SESSION["status"] = "Movement is removed successfully!!";
		    $_SESSION["status_code"] = "success";
		    header("Location: team_info.php?team_id=".$team_id);
		} else {
		    $_SESSION["status"] = "Removing Movement failed";
		    $_SESSION["status_code"] = "warning";
		    header("Location: team_info.php?team_id=".$team_id);
		}
	}

?>