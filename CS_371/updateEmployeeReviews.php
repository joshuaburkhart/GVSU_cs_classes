<?php

	$cName=$_GET['cName']; 
	$streetNum=$_GET['streetNum'];
	$streetNme=$_GET['streetNme'];
	$city=$_GET['city'];
	$stateProvence=$_GET['stateProvence'];
	$zipPostal=$_GET['zipPostal'];
	$firstNme=$_GET['firstNme'];
	$lastNme=$_GET['lastNme'];
	$sex=$_GET['sex'];

	$user_name = 'burkhajg';
	$password = 'SjlSjlSjl1';
	$database = 'burkhajg';
	$server = 'burkhajg.db.2951701.hostedresource.com';
	$db_handle = mysql_connect($server, $user_name, $password);
	$db_found = mysql_select_db($database, $db_handle);
		
		if(db_found) {

					$fullResult = "";

					//this query should return all of the employee reviews for this employee
					$reviewQuery = "
									SELECT DISTINCT leadership,teamWork,workEthic,comment,timeStamp
									FROM EmployeeReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
											AND	firstNme 		= '$firstNme'
											AND	lastNme 		= '$lastNme'
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
							
								$timeStamp = mysql_result($result,$currentrow,"timeStamp");
								$leadership = mysql_result($result,$currentrow,"leadership");
								$teamWork = mysql_result($result,$currentrow,"teamWork");
								$workEthic = mysql_result($result,$currentrow,"workEthic");
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
																				<td>Leadership: $leadership</td>
																			</tr>
																			<tr>
																				<td>Work Ethic: $workEthic</td>
																			</tr>
																			<tr>
																				<td>Team Work: $teamWork</td>
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
?>
