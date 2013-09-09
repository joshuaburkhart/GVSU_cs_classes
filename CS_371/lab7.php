<?php

$user_name = 'burkharj';
$password = 'XXXXXXXX';
$database = 'burkharj';
$server = 'p3nl50mysql9.secureserver.net';
$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);

connectDB($db_found,$database);//connect and write to the database
$head = dispXML();//display the students.xml file contents and catch xml file as string 
$body = readDB();//read from database and catch xml file as string
createDTD();
createXSL($head);
createXML($body);
mysql_close($db_handle);//close the db connection
header("Location: lab7.xml");//redirect to the newly created xml file

function connectDB($db_found,$database) {
	if(!$db_found) {//if the db is not found
		echo "Database . $database . not found";
	}//end if
	else {//if the db is found
		$fp = fopen('teams.txt', 'r');//get ready to read the teams file
		if(!$fp) {//if the file won't open
			echo "teams.txt failed to open";
		}//end if
		else {//if the file opens
			while(!feof($fp)) {//while we're still reading the file
				insertDB($fp);
			}//end while
			fclose($fp);
		}//end else
	}//end else
}//end connectDB function

function insertDB($fp) {
	$line = fgets($fp, 1024);//read a line
	$lineArray = explode(',',$line);//explode it
	$id = $lineArray[0];
	$name = $lineArray[1];
	$league = intval($lineArray[2]);
	$statement = "INSERT INTO Team VALUES ('$id', '$name', $league);";//make SQL statement
	mysql_query($statement);//run it
}//end insertDB function

function dispXML() {
$xmlDoc = new DOMDocument();
$xmlDoc -> load('schools.xml');

$schools = $xmlDoc -> getElementsByTagName('school');
$xml = "<table align='center' border='1'>\n";
$xml = $xml . " <tr bgcolor='#009999'>\n  <td>School</td>\n  <td>State</td>\n </tr>\n";
foreach($schools AS $school) {
	
	$name = $school -> getElementsByTagName('name') -> item(0) -> nodeValue;
	$state = $school -> getElementsByTagName('state') -> item(0) -> nodeValue;

	$pos = strpos($name, '&');
	if($pos !== false) {//if an ampersand is in the team name
		$name = "<![CDATA[" . $name . "]]>";
	}//end if

	$xml = $xml . " <tr>\n  <td>$name</td>\n  <td>$state</td>\n </tr>\n";
}//end for
$xml = $xml . "</table>\n";

return $xml;
}//end dispXML function

function readDB() {
$query = "SELECT * FROM Team WHERE league = 2";
$result = mysql_query($query);
$num = mysql_numrows($result);

$xmlDoc = new DomDocument("");
$xmlDoc -> formatOutput = true;
$root = $xmlDoc -> createElement('schools');
$xmlDoc -> appendChild($root);
$idx = 0;
	while($idx < $num) {
		$DBid = mysql_result($result,$idx,'ID');
		$DBname = mysql_result($result,$idx,'name');
		$DBleague = mysql_result($result,$idx,'league');
		$DBleague = str_replace('2','Big 10',$DBleague);
		
		$school = $xmlDoc -> createElement('school');
		$root -> appendChild($school);

		$id = $xmlDoc -> createElement('ID');
		$id -> appendChild($xmlDoc -> createTextNode($DBid));
		$school -> appendChild($id);
		$name = $xmlDoc -> createElement('name');
		$name -> appendChild($xmlDoc -> createTextNode($DBname));
		$school -> appendChild($name);
		$league = $xmlDoc -> createElement('league');
		$league -> appendChild($xmlDoc -> createTextNode($DBleague));
		$school -> appendChild($league);
			
		$idx++;
	}//end while
	$xml = $xmlDoc -> saveXML();//saves the xml document as a string
	$xml = str_replace('<?xml version=""?>',"<?xml-stylesheet type='text/xsl' href='lab7.xsl'?>\n",$xml);//strips header
	return $xml;//returns the string
}//end readDB function

function createXML($body) {
	
	$xm = fopen('lab7.xml', 'w');
	if(!$xm) {//file failed to open
		echo "lab7.xml failed to open";
	}//end if
	else {
		fwrite($xm, "<?xml version='1.0' encoding='ISO-8859-1'?>\n");
		fwrite($xm, "<!DOCTYPE SPORT SYSTEM 'lab7.dtd'>\n");
		/*fwrite($xm, "<?xml-stylesheet type='text/xsl' href='lab7.xsl'?>\n");*/
		fwrite($xm, $body);
		fclose($xm);//close the filepointer
	}//end else
}//end createXML function

function createXSL($head) {
	$xs = fopen('lab7.xsl', 'w');
	if(!$xs) {//file failed to open
		echo "lab7.xsl failed to open";
	}//end if
	else {
	fwrite($xs, "<?xml version='1.0' encoding='ISO-8859-1'?>\n");
	fwrite($xs, "<xsl:stylesheet version='1.0' xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>\n");
	fwrite($xs, "<xsl:template match='/'>\n");
	fwrite($xs, "<html>\n");
	fwrite($xs, "<head>\n");
 	fwrite($xs, "<link href='lab2.css' rel='stylesheet' type='text/css'/>\n");
 	fwrite($xs, "</head>\n");
	fwrite($xs, "<body>\n");
 	fwrite($xs, "<h1 align='center'>Joshua Burkhart's CS 371 Lab 7</h1>\n");
	fwrite($xs, "<!--nav-->\n");
	fwrite($xs, "<table  id='navtable' width='100%' align='center'>\n");
    	fwrite($xs, "<tr height='7'></tr>\n");
    	fwrite($xs, "<tr id='nav'>\n");
       	fwrite($xs, " <td><div><a href='http://www.corporateear.com/lab1.html'>");
	fwrite($xs, "<font id='invis'>__</font>Lab 1<font id='invis'>__</font>");
	fwrite($xs, "</a></div></td>\n");
       	fwrite($xs, " <td><div><a href='CS371Lab2.html'>");
	fwrite($xs, "<font id='invis'>__</font>Lab 2<font id='invis'>__</font>");
	fwrite($xs, "</a></div></td>\n");
        fwrite($xs, "<td><div><a href='CS371lab3.html'>");
	fwrite($xs, "<font id='invis'>__</font>lab 3<font id='invis'>__</font>");
	fwrite($xs, "</a></div></td>\n");
	fwrite($xs, "<td><div><a href='index.html'>");
	fwrite($xs, "<font id='invis'>__</font>lab 4<font id='invis'>__</font>");
	fwrite($xs, "</a></div></td>\n");
	fwrite($xs, "<td><div><a href='lab5.php'>");
	fwrite($xs, "<font id='invis'>__</font>lab 5<font id='invis'>__</font>");
	fwrite($xs, "</a></div></td>\n");
        fwrite($xs, "<td><div><a href='lab2.css'>");
	fwrite($xs, "<font id='invis'>__</font>CSS Style Sheet<font id='invis'>__</font>");
	fwrite($xs, "</a></div></td>\n");
   	fwrite($xs, "</tr>\n");
	fwrite($xs, "<tr height='12'></tr>\n");
	fwrite($xs, "</table>\n");
	fwrite($xs, "<br></br>\n<h1 align='center'>Schools from provided .xml file</h1>\n");
	fwrite($xs, $head);
	fwrite($xs, "<br></br>\n<h1 align='center'>Big 10 Schools</h1>\n");
	fwrite($xs, "<br></br>\n");
	fwrite($xs, "<table align='center' border='1'>\n");
	fwrite($xs, "<tr bgcolor='#FF7F24'><td>ID</td><td>name</td><td>league</td></tr>\n");
	fwrite($xs, "<xsl:for-each select='schools/school'>\n");
	fwrite($xs, "<tr bgcolor='FFFFFF'>\n");
	fwrite($xs, "<td><xsl:value-of select='ID'/></td>\n");
	fwrite($xs, "<td><xsl:value-of select='name'/></td>\n");
	fwrite($xs, "<td><xsl:value-of select='league'/></td>\n");
	fwrite($xs, "</tr>\n");
	fwrite($xs, "</xsl:for-each>\n");
	fwrite($xs, "</table><br></br>\n");
	fwrite($xs, "</body>\n");
	fwrite($xs, "</html>\n");
	fwrite($xs, "</xsl:template>\n");
	fwrite($xs, "</xsl:stylesheet>\n");
	fclose($xs);//close the filepointer
	}//end else
}//end createXSL function

function createDTD() {
	$dt = fopen('lab7.dtd', 'w');
	if(!$dt) {//file failed to open
		echo "lab7.dtd failed to open";
	}//end if
	else {
	fwrite($dt, "<!ELEMENT SCHOOLS (SCHOOL*)>\n");
	fwrite($dt, "<!ELEMENT SCHOOL (ID*, NAME*, LEAGUE*)>\n");
	fwrite($dt, "<!ELEMENT ID (#PCDATA)>\n");
	fwrite($dt, "<!ELEMENT NAME (#PCDATA)>\n");
	fwrite($dt, "<!ELEMENT LEAGUE (#PCDATA)>\n");
	fclose($dt);//close the filepointer
	}//end else
}//end createDTD function
?>














