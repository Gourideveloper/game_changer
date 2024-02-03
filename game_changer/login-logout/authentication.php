<?php 
session_start(); 
include('../database/db_conn.php'); 

if (isset($_POST['name']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$name = validate($_POST['name']);
	$password = validate($_POST['password']);

	if (empty($name)) {

		$_SESSION['status'] = "Coach Name is required";
		$_SESSION['status_code'] = "warning";
		header("Location: login.php");

	}else if(empty($password)){

		$_SESSION['status'] = "Password is required";
		$_SESSION['status_code'] = "warning";
		header("Location: login.php");

	}else{
		$sql = "SELECT * FROM coach WHERE coach_name='$name' AND password='$password'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['coach_name'] === $name && $row['password'] === $password) {
            	$_SESSION['coach_name'] = $row['coach_name'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: ../pages/index.php");
		        exit();
            }else{

            	$_SESSION['status'] = "Incorect Coach Name or password";
				$_SESSION['status_code'] = "error";
				header("Location: login.php");
			}
		}else{
			
			$_SESSION['status'] = "Incorect Coach Name or password";
			$_SESSION['status_code'] = "error";
			header("Location: login.php");
		}
	}
	
}else{
	header("Location: login.php");
	exit();
}