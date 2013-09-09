<?php
	function insertEmployee() {		
		
		$firstNme=$_GET['firstNme'];
		$lastNme=$_GET['lastNme'];
		$sex=$_GET['sex'];
		$position=$_GET['position'];
		$cName=$_GET['cName'];
		$cNameArray = explode('\"',$cName);
		$cName = $cNameArray[sizeof($cNameArray) - 1];
		$streetNum=$_GET['streetNum'];
		$streetNme=$_GET['streetNme'];
		$city=$_GET['city'];
		$stateProvence=$_GET['stateProvince'];
		$zipPostal=$_GET['zipPostal'];
		$zipPostalArray = explode('\"',$zipPostal);
		$zipPostal = str_replace('\\','',$zipPostalArray[0]);
		$ipaddress=$_SERVER['REMOTE_ADDR'];


		/*
		cName  			varchar(40)  	NO  	PRI  	NULL  	 
		streetNum 		int(11) 		NO 		PRI 	NULL 	 
		streetNme 		varchar(40) 	NO 		PRI 	NULL 	 
		city 			varchar(40) 	NO 		PRI 	NULL 	 
		stateProvence 	varchar(40) 	NO 		PRI 	NULL 	 
		zipPostal 		char(10) 		NO 		PRI 	NULL 	 
		firstNme 		varchar(40) 	NO 		PRI 	NULL 	 
		lastNme 		varchar(40) 	NO 		PRI 	NULL 	 
		sex 			char(1) 		NO 		PRI 	NULL 	 
		position 		varchar(40) 	YES 		  	NULL 	 
		imageUrl 		varchar(40) 	YES 		  	NULL 	 
		timeStamp 		datetime 		YES 	 	 	NULL 	 
		uploadedBy 		char(39) 		YES 	 	 	NULL
		*/

		// Make a MySQL Connection
		$user_name = 'burkhajg';
		$password = 'SjlSjlSjl1';
		$database = 'burkhajg';
		$server = 'burkhajg.db.2951701.hostedresource.com';
		$db_handle = mysql_connect($server, $user_name, $password) or die(mysql_error());
		$db_found = mysql_select_db($database, $db_handle) or die(mysql_error());

		// Insert a row of information into the table "Employee"
		mysql_query("INSERT INTO Employee
		(firstNme, lastNme, sex, position, cName, streetNum, streetNme, city, stateProvence, zipPostal, timestamp, uploadedBy) VALUES('$firstNme', '$lastNme', '$sex', '$position', '$cName', '$streetNum', '$streetNme', '$city', '$stateProvence', '$zipPostal', NOW(),  '$ipaddress') ")
		or die(mysql_error());

		echo "<div class='block'>
				<br>
				</br>
					Employee '$firstNme $lastNme' created successfully.
				<br>
				</br>
			 </div>";

		mysql_close($db_handle);//close the db connection

	}//end insertEmployee function
	insertEmployee();
?>
