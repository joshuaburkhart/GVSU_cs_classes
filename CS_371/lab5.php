<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<?php

$fp = fopen('temps.txt', 'r');

if(!$fp) {
	
	echo "file failed to open";

}//end if
else {
	$size = filesize('temps.txt');

	echo '<table>';

	while(!feof ($fp)) {

		$buffer = fgets($fp, 1024);
		echo "<tr>$buffer</tr>";

	}//end while
	
	echo '</table>';

}//end else

$fp.fclose($fp);

?>

<html>
 
<head>

<link href="lab2.css" rel="stylesheet" type="text/css">
 
</head>

<body>
 
<h1 align="center">Joshua Burkhart's CS 371 Lab 5</h1>
 
<!--nav-->

<table  id="navtable" width="100%" align="center">

   <tr>
</tr>
 
   <tr id="nav">
 
       <td><div><a href="http://www.corporateear.com/lab1.html"><font 	id="invis">__</font>Lab 1<font id="invis">__</font></a></div>
	</td>

        <td><div><a href="CS371Lab2.html"><font id="invis">__</font>Lab 2<font id="invis">__</font></a></div></td>

        <td><div><a href="CS371lab3.html"><font id="invis">__</font>lab 3<font id="invis">__</font></a></div></td>

	<td><div><a href="lab4.html"><font id="invis">__</font>lab 4<font id="invis">__</font></a></div></td>

        <td><div><a href="lab2.css"><font id="invis">__</font>CSS Style Sheet<font id="invis">__</font></a></div></td>

    </tr>

<tr>
</tr>

</table>

<br>

<table border="1" width="80%" align="center">

    </tr>

        <td id="cell1"  align="center">
	</td>

        <td id="cell2"  align="center"></td>

        <td id="cell3"  align="center"></td>

    </tr>

    <tr>

        <td id="cell4"  align="center"></td>

        <td id="cell5"  align="center"></td>

        <td id="cell6"  align="center"></td>

    </tr>

    <tr>

        <td id="cell7" align="center"></td>

        <td id="cell8" align="center"></td>

        <td id="cell9" align="center"></td>

    </tr>

    <tr>

        <td id="cell10"  align="center"></td>

        <td id="cell11"  align="center"></td>

        <td id="cell12"  align="center"></td>

    </tr>

    <tr>

        <td align="center"></td>

        <td align="center"></td>

        <td align="center"></td>

    </tr>

</table>

</body>

</html> 