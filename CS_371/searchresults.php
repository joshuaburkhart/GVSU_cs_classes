<?php
	function main() {
	
		$search = $_GET['search'];
		$search = str_replace(" ","_",$search);
		$search = str_replace("'","*",$search);
		$search = str_replace('"','#',$search);
		$search = str_replace("/","-",$search);
		$replacedSearch = str_replace(","," ",$search);
		$explodedSearch = explode(" ",$replacedSearch,99);//breaking the search into terms
		$searchEmployees = $_GET['emps'];
		$searchCompanies = $_GET['comps'];

		$user_name = 'burkhajg';
		$password = 'SjlSjlSjl1';
		$database = 'burkhajg';
		$server = 'burkhajg.db.2951701.hostedresource.com';
		$db_handle = mysql_connect($server, $user_name, $password);
		$db_found = mysql_select_db($database, $db_handle);
		
		if(db_found) {
			$fullResult = "<p>Not what you're looking for? Add <a id='link' href='javascript:addEntity(\"" . $search . "\")'>" . $search . "</a>.</p>\n";
				$expression = "'";
				$i = 0;
				for($i = 0; $i < sizeof($explodedSearch) - 1; $i++) {//going through the array of search terms (except the last one)
					$expression = $expression . "" . $explodedSearch[$i] . "|";
				}//end for
				$expression = $expression . "" . $explodedSearch[$i] . "'";

			if($searchEmployees === "true") {//if searching for employees

				   $query = "
								SELECT DISTINCT cName, streetNum, streetNme, city, stateProvence, zipPostal, firstNme, lastNme, sex, position 
								FROM Employee
								WHERE 		cName 			REGEXP $expression
										OR 	streetNum 		REGEXP $expression
										OR 	streetNme 		REGEXP $expression
										OR 	city 			REGEXP $expression
										OR 	stateProvence 	REGEXP $expression
										OR 	zipPostal 		REGEXP $expression
										OR 	firstNme 		REGEXP $expression
										OR 	lastNme 		REGEXP $expression
										OR 	position 		REGEXP $expression
								ORDER BY lastNme
							";

					$result = mysql_query($query);
					if($result) {
						$numrows = mysql_num_rows($result);
						$currentrow = 0;
						while($currentrow < $numrows) {
							$cName = mysql_result($result,$currentrow,"cName");
							$streetNum = mysql_result($result,$currentrow,"streetNum");
							$streetNme = mysql_result($result,$currentrow,"streetNme");
							$city = mysql_result($result,$currentrow,"city");
							$stateProvence = mysql_result($result,$currentrow,"stateProvence");
							$zipPostal = mysql_result($result,$currentrow,"zipPostal");
							$firstNme = mysql_result($result,$currentrow,"firstNme");
							$lastNme = mysql_result($result,$currentrow,"lastNme");
							$sex = mysql_result($result,$currentrow,"sex");
							$position = mysql_result($result,$currentrow,"position");
							$fullResult = $fullResult . "<div class='block'>
												<table>
													<tr>
														<td> 
															<a href='javascript:findEmployee(\"$cName\",\"$streetNum\",\"$streetNme\",\"$city\",\"$stateProvence\",\"$zipPostal\",\"$firstNme\",\"$lastNme\",\"$sex\",\"$position\")'>$lastNme $firstNme</a>
														</td>
													</tr>
													<tr>
														<td>
															$position $sex
														</td>
													</tr>
													<tr>
														<td>
															$cName
														</td>
													</tr>
													<tr>
														<td>
															$streetNum $streetNme $city $stateProvence
														</td>
													</tr>
												</table>
											</div>";
							$currentrow++;
						}//end while
					}//end if
			}//end if
			if($searchCompanies === "true") {//if searching for companies

				   $query = "
								SELECT DISTINCT cName, streetNum, streetNme, city, stateProvence, zipPostal 
								FROM Company
								WHERE 		cName 			REGEXP $expression
										OR 	streetNum 		REGEXP $expression
										OR 	streetNme 		REGEXP $expression
										OR 	city 			REGEXP $expression
										OR 	stateProvence 	REGEXP $expression
										OR 	zipPostal 		REGEXP $expression
								ORDER BY cName
							";

					$result = mysql_query($query);
					if($result) {
						$numrows = mysql_num_rows($result);
						$currentrow = 0;
						while($currentrow < $numrows) {
							$cName = mysql_result($result,$currentrow,"cName");
							$streetNum = mysql_result($result,$currentrow,"streetNum");
							$streetNme = mysql_result($result,$currentrow,"streetNme");
							$city = mysql_result($result,$currentrow,"city");
							$stateProvence = mysql_result($result,$currentrow,"stateProvence");
							$zipPostal = mysql_result($result,$currentrow,"zipPostal");
							$fullResult = $fullResult . "<div class='block'>
												<table>
													<tr>
														<td>
															<a href='javascript:findCompany(\"$cName\",\"$streetNum\",\"$streetNme\",\"$city\",\"$stateProvence\",\"$zipPostal\")'>$cName</a>
														</td>
													</tr>
													<tr>
														<td>
															$streetNum $streetNme $city $stateProvence
														</td>
													</tr>
												</table>
											</div>";
											
							$currentrow++;
						}//end while
					}//end if
			}//end if
			echo $fullResult;
		}//end if
		else {//if the db was not found
			$fullResult = "Database was not found";
		}//end else
		mysql_close($db_handle);//close the db connection
	}//end main function
	main()
?>
