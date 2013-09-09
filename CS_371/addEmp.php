<?php 

function createForm() {
	$cName = $_GET['cName'];
	$streetNum = $_GET['streetNum'];
	$streetNme = $_GET['streetNme'];
	$city = $_GET['city'];
	$stateProvence = $_GET['stateProvence'];
	$zipPostal = $_GET['zipPostal'];
	$entityName=$_GET['nme'];
	$explodedName=explode("_",$entityName); 
	$guessFirst=$explodedName[0]; 
	$guessLast=$explodedName[sizeof($explodedName) - 1];
	
	echo "<div class='block'>
  <form id='emp' name='emp'>
    <table width='100%' border='0' cellspacing='0' cellpadding='5'>
      <tr>
        <td>
          <div align='center'>
            <img src='/images/DefaultEmployee.jpg' alt='Employee' width='100' height='100'>
          </div>
        </td>
        <td>&nbsp;
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align='right'>Last Name:
          </div>
        </td>
        <td>
          <input type='text' id='lastNme' name='lastNme' value='$guessLast' tabindex='0'>
		  <input type='hidden' id='company' value='$cName~$streetNum~$streetNme~$city~$stateProvence~$zipPostal'>
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align='right'>First Name: 
          </div>
        </td>
        <td>
          <input type='text' id='firstNme' name='firstNme' value='$guessFirst' tabindex='1'>
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align='right'>Sex:
          </div>
        </td>
        <td>
          <select id='sex' name='sex' tabindex='2'>
            <option value='M'>Male
            </option>
            <option value='F'>Female
            </option>
          </select>             
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align='right'>Position:
          </div>
        </td>
        <td>
          <input type='text' id='position' name='position' tabindex='3'>
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>&nbsp;
        </td>
        <td>&nbsp;
        </td>
        <td width='100' id='createbutton'>
          <div align='right'>
            <a onClick='createEmp()' onMouseOut='MM_swapImgRestore()' onMouseOver='MM_swapImage(\"createbutton\",\"\",\"/images/CreateButtonOver.jpg\",1)'>
              <img src='/images/CreateButtonUp.jpg' alt='Create' name='createbutton' width='100' height='32' border='0' align='top' id='createbutton'/>
            </a>
          </div>
        </td>
      </tr>
    </table>
  </form>
</div>";
}//end createForm function
createForm();
?>
