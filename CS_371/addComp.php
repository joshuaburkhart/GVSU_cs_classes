<?php 
	function createForm() { 
		$entityName=$_GET['nme']; 
		echo '<div class="block">
  <form id="comp" name="comp">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>
          <div align="center">
            <img src="/images/DefaultCompany.jpg" alt="Company" width="100" height="100">
          </div>
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align="right">Company Name: 
          </div>
        </td>
        <td>
          <input type="text" id="cName" name="cName" value="' . $entityName . '" tabindex="0"/>
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align="right">Company Street Address: 
          </div>
        </td>
        <td>
          <input type="text" id="strAddr" name="strAddr" tabindex="1"/>
        </td>
        <td>&nbsp;
        </td>
      </tr>
		<tr>
        <td>
          <div align="right">City:
          </div>
        </td>
        <td>
          <input type="text" id="city" name="city" tabindex="2"/>
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align="right">State / Province:
          </div>
        </td>
        <td>
          <input type="text" id="stateProvince" name="stateProvince" tabindex="3"/>
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>
          <div align="right">Zip / Postal Code: 
          </div>
        </td>
        <td>
          <input type="text" id="zipPostal" name="zipPostal" tabindex="4"/>
        </td>
        <td>&nbsp;
        </td>
      </tr>
      <tr>
        <td>&nbsp;
        </td>
        <td>&nbsp;
        </td>
        <td width="100" id="createbutton">
          <div align="right">
            <a onclick="createComp()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'createbutton\',\'\',\'/images/CreateButtonOver.jpg\',1)">
              <img src="/images/CreateButtonUp.jpg" alt="Create" name="createbutton" width="100" height="32" border="0" align="top" id="createbutton"/>
            </a>
          </div>
        </td>
      </tr>
    </table>
  </form>
</div>';
}//end createForm function
createForm();
?>
