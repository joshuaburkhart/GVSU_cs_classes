<?php

	$user_name = 'burkhajg';
	$password = 'SjlSjlSjl1';
	$database = 'burkhajg';
	$server = 'burkhajg.db.2951701.hostedresource.com';
	$db_handle = mysql_connect($server, $user_name, $password);
	$db_found = mysql_select_db($database, $db_handle);
	$recentQuery = "
					SELECT *
					FROM EmployeeReview
					ORDER BY timeStamp DESC
				   ";
	$fullResult = "";

	if(db_found) {

		$result = mysql_query($recentQuery);
						
						if($result) {
						
						//this should return a list of employee reviews
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
							
								$lastNme = mysql_result($result,$currentrow,"lastNme");
								$firstNme = mysql_result($result,$currentrow,"firstNme");
								$cNmae = mysql_result($result,$currentrow,"cName");
								$timestamp = mysql_result($result,$currentrow,"timeStamp");
								$leadership = mysql_result($result,$currentrow,"leadership");
								$teamWork = mysql_result($result,$currentrow,"teamWork");
								$workEthic = mysql_result($result,$currentrow,"workEthic");
								$comment = mysql_result($result,$currentrow,"comment");
								$comment =  wordwrap($comment, 35, "\n", true);
							
								$fullResult = $fullResult . "<div class='block'>
															<table width='90%' border='0' cellspacing='0' cellpadding='5'>
 																<tr>
   																	<td>$timeStamp</td>
  																</tr>
  																<tr>
																	<td>
																		<table width='200'>
																			<tr>
																				<td>Company: $cName</td>
																			</tr>
																			<tr>
																				<td>Name: $lastNme, $firstNme</td>
																			</tr>
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
    																<td style='background-color:lightgray;text-align:left;'><p width='200'>\"$comment\"</p></td>
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
