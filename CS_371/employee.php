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
	$position=$_GET['position'];

	$user_name = 'burkhajg';
	$password = 'SjlSjlSjl1';
	$database = 'burkhajg';
	$server = 'burkhajg.db.2951701.hostedresource.com';
	$db_handle = mysql_connect($server, $user_name, $password);
	$db_found = mysql_select_db($database, $db_handle);
		
		if(db_found) {

					$fullResult = "";
					
				   //this query should return only one employee
				   $employeeQuery = "
								SELECT DISTINCT cName, streetNum, streetNme, city, stateProvence, zipPostal, firstNme, lastNme, sex, position 
								FROM Employee
								WHERE 		cName 			= '$cName'
										AND	streetNum 		= '$streetNum'
										AND	streetNme 	 	= '$streetNme'
										AND	city 			= '$city'
										AND stateProvence 	= '$stateProvence'
										AND	zipPostal 		= '$zipPostal'
										AND	firstNme 		= '$firstNme'
										AND	lastNme 		= '$lastNme'
							";
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
					//this query should return the average leadership for this employee
					$leadershipQuery = "
									SELECT AVG(leadership)
									FROM EmployeeReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
											AND	firstNme 		= '$firstNme'
											AND	lastNme 		= '$lastNme'
									";
					//this query should return the average teamWork for this employee
					$teamWorkQuery = "
									SELECT AVG(teamWork)
									FROM EmployeeReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
											AND	firstNme 		= '$firstNme'
											AND	lastNme 		= '$lastNme'
									";
					//this query should return the average workEthic for this employee
					$workEthicQuery = "
									SELECT AVG(workEthic)
									FROM EmployeeReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
											AND	firstNme 		= '$firstNme'
											AND	lastNme 		= '$lastNme'
									";

					$avgLeadership = 0.0;
					$result = mysql_query($leadershipQuery);
					if($result) {
						$avgLeadership = mysql_result($result,0);
					}//end if
					$avgTeamWork = 0.0;
					$result = mysql_query($teamWorkQuery);
					if($result) {
						$avgTeamWork = mysql_result($result,0);
					}//end if
					$avgWorkEthic = 0.0;
					$result = mysql_query($workEthicQuery);
					if($result) {
						$avgWorkEthic = mysql_result($result,0);
					}//end if

					$result = mysql_query($employeeQuery);
					
					if($result) {
						
						//this should return the main screen with an image, average obj ratings, and employee information, and fields for submitting a review
							$cName = mysql_result($result,0,"cName");
							$streetNum = mysql_result($result,0,"streetNum");
							$streetNme = mysql_result($result,0,"streetNme");
							$city = mysql_result($result,0,"city");
							$stateProvence = mysql_result($result,0,"stateProvence");
							$zipPostal = mysql_result($result,0,"zipPostal");
							$firstNme = mysql_result($result,0,"firstNme");
							$lastNme = mysql_result($result,0,"lastNme");
							$sex = mysql_result($result,0,"sex");
							$position = mysql_result($result,0,"position");
						
						$fullResult = $fullResult . "<div class='eblock'>
														<form id='form2' name='form2' onsubmit='return false;'>						
<table width='90%' border='0' cellspacing='0' cellpadding='5'>
  <tr>
    <td rowspan='3'><div align='center'><img src='/images/DefaultEmployee.jpg' alt='company' width='100' height='100' /></div></td>
    <td>$lastNme, $firstNme </td>
  </tr>
  <tr>
    <td>$position, $cName </td>
  </tr>
  <tr>
    <td>$city, $stateProvence, $zipPostal </td>
  </tr>
  <tr>
    <td><div align='right'>Team Work:
	</div></td>
    <td><select name='teamWork' id='teamWork'>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
      (Avg: $avgTeamWork) </td>
  </tr>
  <tr>
    <td><div align='right'>Work Ethic : </div></td>
    <td><select name='workEthic' id='workEthic'>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
      (Avg: $avgWorkEthic) </td>
  </tr>
  <tr>
    <td><div align='right'>Leadership: </div></td>
    <td><select name='leadership' id='leadership'>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
      (Avg: $avgLeadership) </td>
  </tr>
  <tr>
    <td valign='top'><div align='right'>Comment:
	</div></td>
    <td valign='top'><textarea name='comment' id='comment' cols='70' rows='7'></textarea></td>
  </tr>
  <tr>
    <td valign='top'>&nbsp;</td>
    <td valign='top'><input type='submit' name='Submit' value='Submit' onclick='employeeReview(\"$lastNme\",\"$firstNme\",\"$sex\",\"$cName\",\"$streetNum\",\"$streetNme\",\"$city\",\"$stateProvence\",\"$zipPostal\")'/></td>
  </tr>
</table>
													</div>";
						}//end if
														
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
								$leadership = mysql_result($result,$currentrow,"leadership");
								$teamWork = mysql_result($result,$currentrow,"teamWork");
								$workEthic = mysql_result($result,$currentrow,"workEthic");
								$comment = mysql_result($result,$currentrow,"comment");
								$comment =  wordwrap($comment, 40, "\n", true);								

								$fullResult = $fullResult . "<div class='singleReview'>
															<table width='90%' border='0' cellspacing='0' cellpadding='5'>
 																<tr>
   																	<td>$timeStamp</td>
  																</tr>
  																<tr>
																	<td>
																		<table width='200'>
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
					else {//if $result is false
						
						$fullResult = $fullResult . "<div class='block' id='resultblock'>
														No reviews have been written yet. You can be the first!
													</div>";

					}//end else
					echo $fullResult;
			}//end if
			else {//if the db was not found
				echo "Database was not found";
			}//end else
		mysql_close($db_handle);//close the db connection
?>
