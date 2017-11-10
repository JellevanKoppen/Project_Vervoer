<?php
    if(!isset($error_message)) {
    	require_once("dbcontroller.php");
    	$db_handle = new DBController();
    	$query = INSERT INTO registered_users (user_name, first_name, last_name, password, email, gender) VALUES
    	('" . $_POST["userName"] . "', '" . $_POST["firstName"] . "', '" . $_POST["lastName"] . "', '" . md5($_POST["password"]) . "', '" . $_POST["userEmail"] . "', '" . $_POST["gender"] . "');
    	$result = $db_handle->insertQuery($query);
    	if(!empty($result)) {
    		$error_message = "";
    		$success_message = "You have registered successfully!";
    		unset($_POST);
    	} else {
    		$error_message = "Problem in registration. Try Again!";
    	}
    } ?>
