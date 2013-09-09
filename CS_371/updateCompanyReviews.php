<?php

	$cName=$_GET['cName']; 
	$streetNum=$_GET['streetNum'];
	$streetNme=$_GET['streetNme'];
	$city=$_GET['city'];
	$stateProvence=$_GET['stateProvence'];
	$zipPostal=$_GET['zipPostal'];

	$user_name = 'burkhajg';
	$password = 'SjlSjlSjl1';
	$database = 'burkhajg';
	$server = 'burkhajg.db.2951701.hostedresource.com';
	$db_handle = mysql_connect($server, $user_name, $password);
	$db_found = mysql_select_db($database, $db_handle);
		
		if(db_found) {

					$fullResult = "";

					//this query should return all of the company reviews for this company
					$reviewQuery = "
									SELECT DISTINCT policy,efficiency,workEnvironment,comment,timeStamp
									FROM CompanyReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
									ORDER BY timeStamp DESC
							";

					$result = mysql_query($reviewQuery);
						
						if($result) {

						//this should return the employee reviews with comments, and obj ratings
						$numrows = mysql_num_rows($result);
						if($numrows == 0) {
						
							$fullResult = $fullResult . "<div class='block' id='resultblock'>
															No reviews have been written yet. You can be the first!
														</div>";
						}//end if
						else {
						
							$fullResult = $fullResult . "<div class='block' id='resultblock'>";
						
							$currentrow = 0;
							while($currentrow < $numrows) {
							
								$timestamp = mysql_result($result,$currentrow,"timeStamp");
								$policy = mysql_result($result,$currentrow,"policy");
								$efficiency = mysql_result($result,$currentrow,"efficiency");
								$workEnvironment = mysql_result($result,$currentrow,"workEnvironment");
								$comment = mysql_result($result,$currentrow,"comment");

								$fullResult = $fullResult . "<div class='block'>
															<table width='90%' border='0' cellspacing='0' cellpadding='5'>
 																<tr>
   																	<td>$timeStamp</td>
  																</tr>
  																<tr>
																	<td>
																		<table>
																			<tr>
																				<td>Work Environment: $workEnvironment</td>
																			</tr>
																			<tr>
																				<td>Efficiency: $efficiency</td>
																			</tr>
																			<tr>
																				<td>Policy: $policy</td>
																			</tr>
																		</table>
    																</td>
    																<td style='background-color:lightgray;'>\"$comment\"</td>
  																</tr>
															</table>
														</div>";
								$currentrow++;
							}//end while
						
							$fullResult = $fullResult . "</div>";
							
						}//end else
					}//end if
					echo $fullResult;
			}//end if
			else {//if the db was not found
				echo "Database was not found";
			}//end else
		mysql_close($db_handle);//close the db connection
