<?php
	include_once('connection_bills.php');
	//Call object of class connection and create a new connection to my localhost database
	$connection = new createConnection(); 
	$connection->connectToDatabase();
	$connection->selectDatabase();
	mysql_query('SET CHARACTER SET utf8');
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$day = isset($_POST['day']) ? mysql_real_escape_string($_POST['day']) : "";
	$month = isset($_POST['month']) ? mysql_real_escape_string($_POST['month']) : "";
	$year = isset($_POST['year']) ? mysql_real_escape_string($_POST['year']) : "";
	$bill_value = isset($_POST['bill_value']) ? mysql_real_escape_string($_POST['bill_value']) : "";
	$initial_bill = isset($_POST['initial_bill']) ? mysql_real_escape_string($_POST['initial_bill']) : "";
	$end_bill = isset($_POST['end_bill']) ? mysql_real_escape_string($_POST['end_bill']) : "";

	/* HARDCORE DATA
	$day = "1";
	$month = "12";
	$year = "2016";
	$bill_value = "200";
	$initial_bill = "99600";
	$end_bill = "99602";
	$bill_number = "200";*/

	// Insert data into data base
	$sql = "INSERT INTO `bills` (`id`, `day`, `month`, `year`, `bill_value`, `initial_bill`, `end_bill`) VALUES (NULL, '$day', '$month', '$year', '$bill_value', '$initial_bill', '$end_bill');";
	$qur = mysql_query($sql);
		if($qur){
			$json = array("status" => "OK", "msg" => "Product added successfull!");
		}else{
			$json = array("status" => "NOK", "msg" => "Error occur adding user!");
		}
	}else{
		$json = array("status" => "NOK", "msg" => "Request method not accepted");
	}

@mysql_close($conn);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);

	//Close connection
	$connection->closeConnection();
?>