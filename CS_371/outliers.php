<?php
	$user_name = 'burkhajg';
	$password = 'SjlSjlSjl1';
	$database = 'burkhajg';
	$server = 'burkhajg.db.2951701.hostedresource.com';
	$db_handle = mysql_connect($server, $user_name, $password);
	$db_found = mysql_select_db($database, $db_handle);
		
		if(db_found) {

			$bestCompanyQuery = "
				SELECT cName, streetNum, streetNme, city, stateProvence, zipPostal, (SUM(policy) + SUM(efficiency) + SUM(workEnvironment)) AS tot
				FROM  CompanyReview
				GROUP BY cName, streetNum, streetNme, city, stateProvence, zipPostal
				ORDER BY tot DESC
				LIMIT 1
								";
			$bestEmployeeQuery = "
				SELECT cName, streetNum, streetNme, city, stateProvence, zipPostal, lastNme, firstNme, sex, (SUM(leadership) + SUM(workEthic) + SUM(teamWork)) AS tot
				FROM EmployeeReview
				GROUP BY cName, streetNum, streetNme, city, stateProvence, zipPostal, lastNme, firstNme, sex
				ORDER BY tot DESC
				LIMIT 1
								";
			$worstCompanyQuery = "
				SELECT cName, streetNum, streetNme, city, stateProvence, zipPostal, (SUM(policy) + SUM(efficiency) + SUM(workEnvironment)) AS tot
				FROM  CompanyReview
				GROUP BY cName, streetNum, streetNme, city, stateProvence, zipPostal
				ORDER BY tot
				LIMIT 1
								";
			$worstEmployeeQuery = "
				SELECT cName, streetNum, streetNme, city, stateProvence, zipPostal, lastNme, firstNme, sex, (SUM(leadership) + SUM(workEthic) + SUM(teamWork)) AS tot
				FROM EmployeeReview
				GROUP BY cName, streetNum, streetNme, city, stateProvence, zipPostal, lastNme, firstNme, sex
				ORDER BY tot
				LIMIT 1
								";
					$bestCompanyNme = "None - Best";
					$bestCompanyRtg = 0.0;
					$bestCompanyLink = "<a>";
					$result = mysql_query($bestCompanyQuery);
					if($result) {
						$bestCompanyNme = mysql_result($result,0,"cName");
						$bestCompanyRtg = mysql_result($result,0,"tot");
						$streetNum = mysql_result($result,0,"streetNum");
						$streetNme = mysql_result($result,0,"streetNme");
						$city = mysql_result($result,0,"city");
						$stateProvence = mysql_result($result,0,"stateProvence");
						$zipPostal = mysql_result($result,0,"zipPostal");
						$bestCompanyLink = "<a href='javascript:findCompany(\"$bestCompanyNme\",
																			\"$streetNum\",
																			\"$streetNme\",
																			\"$city\",
																			\"$stateProvence\",
																			\"$zipPostal\")'>";							
					}//end if

					$bestEmployeeLastNme = "Doe - Best";
					$bestEmployeeFirstNme = "John";
					$bestEmployeeRtg = 0.0;
					$bestEmployeeLink = "<a>";
					$result = mysql_query($bestEmployeeQuery);
					if($result) {
						$bestEmployeeLastNme = mysql_result($result,0,"lastNme");
						$bestEmployeeFirstNme = mysql_result($result,0,"firstNme");
						$bestEmployeeRtg = mysql_result($result,0,"tot");
						$streetNum = mysql_result($result,0,"streetNum");
						$streetNme = mysql_result($result,0,"streetNme");
						$city = mysql_result($result,0,"city");
						$stateProvence = mysql_result($result,0,"stateProvence");
						$zipPostal = mysql_result($result,0,"zipPostal");
						$sex = mysql_result($result,0,"sex");
						$position = "X";//due to be deprecated in beta
						$cName = mysql_result($result,0,"cName");
						$bestEmployeeLink = "<a href='javascript:findEmployee(\"$cName\",
																			\"$streetNum\",
																			\"$streetNme\",
																			\"$city\",
																			\"$stateProvence\",
																			\"$zipPostal\",
																			\"$bestEmployeeFirstNme\",
																			\"$bestEmployeeLastNme\",
																			\"$sex\",
																			\"$position\")'>";
					}//end if

					$worstCompanyNme = "None - Worst";
					$worstCompanyRtg = 0.0;
					$worstCompanyLink = "<a>";
					$result = mysql_query($worstCompanyQuery);
					if($result) {
						$worstCompanyNme = mysql_result($result,0,"cName");
						$worstCompanyRtg = mysql_result($result,0,"tot");
						$streetNum = mysql_result($result,0,"streetNum");
						$streetNme = mysql_result($result,0,"streetNme");
						$city = mysql_result($result,0,"city");
						$stateProvence = mysql_result($result,0,"stateProvence");
						$zipPostal = mysql_result($result,0,"zipPostal");
						$worstCompanyLink = "<a href='javascript:findCompany(\"$worstCompanyNme\",
																			\"$streetNum\",
																			\"$streetNme\",
																			\"$city\",
																			\"$stateProvence\",
																			\"$zipPostal\")'>";	
					}//end if

					$worstEmployeeLastNme = "Doe - Worst";
					$worstEmployeeFisrtNme = "John";
					$worstEmployeeRtg = "0.0";
					$worstEmployeeLink = "<a>";
					$result = mysql_query($worstEmployeeQuery);
					if($result) {
						$worstEmployeeLastNme = mysql_result($result,0,"lastNme");
						$worstEmployeeFirstNme = mysql_result($result,0,"firstNme");
						$worstEmployeeRtg = mysql_result($result,0,"tot");
						$streetNum = mysql_result($result,0,"streetNum");
						$streetNme = mysql_result($result,0,"streetNme");
						$city = mysql_result($result,0,"city");
						$stateProvence = mysql_result($result,0,"stateProvence");
						$zipPostal = mysql_result($result,0,"zipPostal");
						$sex = mysql_result($result,0,"sex");
						$position = "X";//due to be deprecated in beta
						$cName = mysql_result($result,0,"cName");
						$worstEmployeeLink = "<a href='javascript:findEmployee(\"$cName\",
																			\"$streetNum\",
																			\"$streetNme\",
																			\"$city\",
																			\"$stateProvence\",
																			\"$zipPostal\",
																			\"$worstEmployeeFirstNme\",
																			\"$worstEmployeeLastNme\",
																			\"$sex\",
																			\"$position\")'>";
					}//end if
					
					echo "<td id='outliers' width='160'>
            <div id='bestcompany' class='outlier'>
			<span id='bannertext'>Best Company
        	</span>
              <p align='center'>
                <img src='/images/DefaultCompany.jpg' alt='Best Rated Company' name='bestcompanyimg' width='100' height='100' id='bestcompanyimg' style='background-color: #999999\'/>
				<br/>
                $bestCompanyLink $bestCompanyNme </a>
                <br/>
                <span id='bestcompanyrtg'>$bestCompanyRtg
                </span>	
              </p>

            </div>
            <div id='bestemployee' class='outlier'>
			<span id='bannertext'>Best Employee
        	</span>
              <p align='center'>
                <img src='/images/DefaultEmployee.jpg' alt='Best Rated Employee' name='bestemployeeimg' width='100' height='100' id='bestemployeeimg' style='background-color: #999999'/>
				<br/>
                $bestEmployeeLink $bestEmployeeLastNme, $bestEmployeeFirstNme </a>
                <br/>	
                <span id='bestemployeertg'>$bestEmployeeRtg
                </span>	
              </p>
            </div>

            <div id='worstcompany' class='outlier'>
			<span id='bannertext'>Worst Company
        	</span>
              <p align='center'>
                <img src='/images/DefaultCompany.jpg' alt='Worst Rated Company' name='worstcompanyimg' width='100' height='100' id='worstcompanyimg' style='background-color: #999999'/>
				<br/>
                $worstCompanyLink $worstCompanyNme </a>
                <br/>
                <span id='worstcompanyrtg'>$worstCompanyRtg
                </span>	
              </p>
            </div>

            <div id='worstemployee' class='outlier'>
			<span id='bannertext'>Worst Employee
        	</span>
              <p align='center'>
                <img src='/images/DefaultEmployee.jpg' alt='Worst Rated Employee' name='worstemployee' width='100' height='100' id='worstemployee' style='background-color: #999999'/>
				<br/>
                $worstEmployeeLink $worstEmployeeLastNme, $worstEmployeeFirstNme </a>
                <br/>
                <span id='wostemployeertg'>$worstEmployeeRtg
                </span>	
              </p>
            </div>	
          </td>";

			}//end if
			else {//if the db was not found
				echo  "Database was not found";
			}//end else
		mysql_close($db_handle);//close the db connection
?>
