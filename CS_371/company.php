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

				   //this query should return only one company
				   $companyQuery = "
								SELECT DISTINCT cName, streetNum, streetNme, city, stateProvence, zipPostal
								FROM Company
								WHERE 		cName 			= '$cName'
										AND	streetNum 		= '$streetNum'
										AND	streetNme 	 	= '$streetNme'
										AND	city 			= '$city'
										AND stateProvence 	= '$stateProvence'
										AND	zipPostal 		= '$zipPostal'
							";
					//this query should return all of the employee reviews for this company
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
					//this query should return the average policy for this company
					$policyQuery = "
									SELECT AVG(policy)
									FROM CompanyReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
									";
					//this query should return the average efficiency for this company
					$efficiencyQuery = "
									SELECT AVG(efficiency)
									FROM CompanyReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
									";
					//this query should return the average workEnvironment for this company
					$workEnvironmentQuery = "
									SELECT AVG(workEnvironment)
									FROM CompanyReview
									WHERE 		cName 			= '$cName'
											AND	streetNum 		= '$streetNum'
											AND	streetNme 	 	= '$streetNme'
											AND	city 			= '$city'
											AND stateProvence 	= '$stateProvence'
											AND	zipPostal 		= '$zipPostal'
									";

					$avgPolicy = 0.0;
					$result = mysql_query($policyQuery);
					if($result) {
						$avgPolicy = mysql_result($result,0);
					}//end if

					$avgEfficiency = 0.0;
					$result = mysql_query($efficiencyQuery);
					if($result) {
						$avgEfficiency = mysql_result($result,0);
					}//end if

					$avgWorkEnvironment = 0.0;
					$result = mysql_query($workEnvironmentQuery);
					if($result) {
						$avgWorkEnvironment = mysql_result($result,0);
					}//end if
					
					$result = mysql_query($companyQuery);
					
					if($result) {
						
						//this should return the main screen with an image, average obj ratings, and employee information, and fields for submitting a review
							$cName = mysql_result($result,0,"cName");
							$streetNum = mysql_result($result,0,"streetNum");
							$streetNme = mysql_result($result,0,"streetNme");
							$city = mysql_result($result,0,"city");
							$stateProvence = mysql_result($result,0,"stateProvence");
							$zipPostal = mysql_result($result,0,"zipPostal");
						
						$fullResult = $fullResult . "<div class='eblock'>
														<form id='form2' name='form2' onsubmit='return false;'>
  <table width='90%' border='0' cellspacing='0' cellpadding='5'>
    <tr>
      <td rowspan='3'><div align='center'><img src='/images/DefaultCompany.jpg' alt='company' width='100' height='100' /></div></td>
      <td>$cName</td>
    </tr>
    <tr>
      <td>$streetNum $streetNme </td>
    </tr>
    <tr>
      <td>$city, $stateProvence, $zipPostal</td>
    </tr>


    <tr>
      <td><div align='right'>Work Environment: 
      </div></td>
      <td><select name='workEnvironment' id='workEnvironment' value='1'>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
      (Avg: $avgWorkEnvironment) </td>
    </tr>
    <tr>
      <td><div align='right'>Efficiency:      
	  </div></td>
      <td><select name='efficiency' id='efficiency' value='1'>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
      (Avg: $avgEfficiency) </td>
    </tr>
    <tr>
      <td><div align='right'>Policy:      
	  </div></td>
      <td><select name='policy' id='policy' value='1'>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
      (Avg: $avgPolicy) </td>
    </tr>
    <tr>
      <td valign='top'><div align='right'>Comment:
	  </div></td>
      <td valign='top'><textarea name='comment' id='comment' value='Add your comment here.' cols='70' rows='7'></textarea></td>
    </tr>
    <tr>
      <td valign='top'>&nbsp;</td>
      <td valign='top'><input type='submit' name='Submit' value='Submit' onclick='companyReview(\"$cName\",\"$streetNum\",\"$streetNme\",\"$city\",\"$stateProvence\",\"$zipPostal\")'/></td>
    </tr>
  </table>
</form>
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
							
							$timeStamp = mysql_result($result,$currentrow,"timeStamp");
							$policy = mysql_result($result,$currentrow,"policy");
							$efficiency = mysql_result($result,$currentrow,"efficiency");
							$workEnvironment = mysql_result($result,$currentrow,"workEnvironment");
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
