<?php 

function createForm() {
	$entityName=$_GET['nme'];

	echo $entityName." ".$guessFirst." ".$guessLast;
	
	$compBox = "";//variable company option box

	// Make a MySQL Connection
	$user_name = 'burkhajg';
	$password = 'SjlSjlSjl1';
	$database = 'burkhajg';
	$server = 'burkhajg.db.2951701.hostedresource.com';
	$db_handle = mysql_connect($server, $user_name, $password) or die(mysql_error());
	$db_found = mysql_select_db($database, $db_handle) or die(mysql_error());

		if(db_found) {		

		$grabComps = "
			SELECT cName,streetNum,streetNme,city,stateProvence,zipPostal
			FROM Company
			ORDER BY cName
					";
		$compList = mysql_query($grabComps); //stores a list of companies as '$compsList'
		if($compList) {
		$numrows = mysql_num_rows($compList);
			$currentrow = 0;
			while($currentrow < $numrows) {
				$cName = mysql_result($compList,$currentrow,"cName");
				$streetNum = mysql_result($compList,$currentrow,"streetNum");
				$streetNme = mysql_result($compList,$currentrow,"streetNme");
				$city = mysql_result($compList,$currentrow,"city");
				$stateProvence = mysql_result($compList,$currentrow,"stateProvence");
				$zipPostal = mysql_result($compList,$currentrow,"zipPostal");
				
				$compBox = $compBox . "<option value='\"$cName $streetNum $streetNme $city $stateProvence $zipPostal\"'>
									   	<b>$cName</b> $streetNum $streetNme $city , $stateProvence $zipPostal
									  </option>";
			$currentrow++;
			}//end while
		}//end if
	}//end if
	mysql_close($db_handle);//close the db connection
	
	echo "
		<div class='block'>
  <table>
    <tr>
      <td align='center'>
        $entityName works for an existing company:
        <select id='company' onchange='addNxt(this.options[this.selectedIndex].value)'>
          <option value='void'>Select Company
          </option>
          $compBox
        </select> 
      </td>
      <td align='center'>
        $entityName works for a new company
        <form id='comp' name='comp'>
          <table width='100%' border='0' cellspacing='0' cellpadding='5'>
            <tr>
              <td>
                <div align='center'>
                  <img src='/images/DefaultCompany.jpg' alt='Company' width='100' height='100'>
                </div>
              </td>
              <td>
                &nbsp;<input type='hidden' id='entity' value='$entityName'>
              </td>
              <td>
                &nbsp;
              </td>
            </tr>
            <tr>
              <td>
                <div align='right'>Company Name: 
                </div>
              </td>
              <td>
                <input type='text' id='cName' name='cName' tabindex='0'/>
              </td>
              <td>&nbsp;
              </td>
            </tr>
            <tr>
              <td>
                <div align='right'>Company Street Address: 
                </div>
              </td>
              <td>
                <input type='text' id='strAddr' name='strAddr' tabindex='1'/>
              </td>
              <td>&nbsp;
              </td>
            </tr>
            <tr>
              <td>
                <div align='right'>City:
                </div>
              </td>
              <td>
                <input type='text' id='city' name='city' tabindex='2'/>
              </td>
              <td>&nbsp;
              </td>
            </tr>
            <tr>
              <td>
                <div align='right'>State / Province:
                </div>
              </td>
              <td>
                <input type='text' id='stateProvince' name='stateProvince' tabindex='3'/>
              </td>
              <td>&nbsp;
              </td>
            </tr>
            <tr>
              <td>
                <div align='right'>Zip / Postal Code: 
                </div>
              </td>
              <td>
                <input type='text' id='zipPostal' name='zipPostal' tabindex='4'/>
              </td>
              <td>&nbsp;
              </td>
            </tr>
            <tr>
              <td>&nbsp;
              </td>
              <td>&nbsp;
              </td>
            </tr>
          </table>
        </form>	
        <button onclick='addNxt(\"newCompany\")'>Create!
        </button>
      </td>
    </tr>
  </table>      
</div>
		";
}//end createForm function
createForm();
?>
