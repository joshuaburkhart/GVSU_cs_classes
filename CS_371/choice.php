<?php
	function createForm() {
		$givenName = $_GET['nme'];
		$entityName = str_replace(" ","_",$givenName);
		echo '<table class="block" width="90%" border="0" cellspacing="0" cellpadding="5">
  				<tr>
   				 <td colspan="2">
				 	<div align="center">' . $givenName . ' is a... 
				 	</div>
				 </td>
  				</tr>
  				<tr>
    				<td>
						<div align="center" class="choice" >
      						<p>
								<img src="/images/DefaultCompany.jpg" onclick="addCompany(\'' . $entityName . '\')"alt="Company" width="100" height="100">
							</p>
     						<p>
								Company
							</p>
    					</div>
					</td>
    				<td>
						<div align="center" class="choice" >
      						<p>
								<img src="/images/DefaultEmployee.jpg" onclick="addEmployee(\'' . $entityName . '\')"alt="Employee" width="100" height="100">
							</p>
      						<p>
								Employee
							</p>
    					</div>
					</td>
  				</tr>
			</table>';
	}//end createForm function
	createForm();
?>


