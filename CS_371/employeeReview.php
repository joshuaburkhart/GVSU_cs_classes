<?php

	$firstNme=$_GET['firstNme'];
	$lastNme=$_GET['lastNme'];
	$sex=$_GET['sex'];
	$leadership=$_GET['leadership'];
	$workEthic=$_GET['workEthic'];
	$teamWork=$_GET['teamWork'];
	$cName=$_GET['cName']; 
	$streetNum=$_GET['streetNum'];
	$streetNme=$_GET['streetNme'];
	$city=$_GET['city'];
	$stateProvence=$_GET['stateProvence'];
	$zipPostal=$_GET['zipPostal'];
	$comment=$_GET['comment'];
	$ipaddress=$_SERVER['REMOTE_ADDR'];
	
	//insert review
		// Make a MySQL Connection
		$user_name = 'burkhajg';
		$password = 'SjlSjlSjl1';
		$database = 'burkhajg';
		$server = 'burkhajg.db.2951701.hostedresource.com';
		$db_handle = mysql_connect($server, $user_name, $password) or die(mysql_error());
		$db_found = mysql_select_db($database, $db_handle) or die(mysql_error());

		// Insert a row of information into the table "EmployeeReview"
		mysql_query("INSERT INTO EmployeeReview 
		(cName, streetNum, streetNme, city, stateProvence, zipPostal, firstNme, lastNme, sex, leadership, teamWork, workEthic, comment, timeStamp, uploadedBy) VALUES('$cName', '$streetNum', '$streetNme', '$city', '$stateProvence', '$zipPostal', '$firstNme', '$lastNme', '$sex', '$leadership', '$teamWork', '$workEthic', '$comment', NOW(),  '$ipaddress') ")
		or die(mysql_error());

		mysql_close($db_handle);//close the db connection
?>
