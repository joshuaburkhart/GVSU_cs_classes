<?php

$fp = fopen('text.txt', 'r');
$xm = fopen('fdoc.xml', 'w');
$dt = fopen('sport.dtd', 'w');
$xs = fopen('fdoc.xsl', 'w');

if(!$fp) {
	
	echo "file failed to open";

}//end if
else {
	$league = "0";
	$id;
	$name;
	$numWins;
	$numLosses;

	//write up the header of the xml document
	fwrite($xm, "<?xml version='1.0' encoding='ISO-8859-1'?>\n");
	fwrite($xm, "<!DOCTYPE SPORT SYSTEM 'sport.dtd'>\n");
	fwrite($xm, "<?xml-stylesheet type='text/xsl' href='fdoc.xsl'?>\n");
	fwrite($xm, "<sport>\n");
	fwrite($xm, "<league>\n");
	fwrite($xm, "	<leagueNum>$league</leagueNum>\n");

	//write up the header of the xsl document
	fwrite($xs, "<?xml version='1.0' encoding='ISO-8859-1'?>\n");
	fwrite($xs, "<xsl:stylesheet version='1.0' xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>\n");

	while(!feof($fp)) {

		$line = fgets($fp, 1024);
		$lineArray = explode(',',$line);
		
		if(strlen($lineArray[0]) < strlen($league)){
			break;//the end of the file has been reached
		}//end if

		//creating xml league tags
		if($league != $lineArray[0]) {
			
			fwrite($xm, "</league>\n");
			$league = $lineArray[0];
			fwrite($xm, "<league>\n");
			fwrite($xm, "	<leagueNum>$league</leagueNum>\n");

		}//end if

		$id = $lineArray[1];
		$name = $lineArray[2];
		$numWins = $lineArray[3];
		$numLosses = $lineArray[4];
		$pos = strpos($name, '&');

		//creating xml guts
		fwrite($xm, "		<team>\n");
		fwrite($xm, "			<teamId>$id</teamId>\n");
		
		if($pos !== false) {//if an ampersand is in the team name
			$name = "<![CDATA[" . $name . "]]>";
		}//end if

		fwrite($xm, "			<teamName>$name</teamName>\n");
		fwrite($xm, "				<wins>$numWins</wins>\n");
		fwrite($xm, "				<losses>$numLosses</losses>\n");
		fwrite($xm, "		</team>\n");
		
	}//end while
	
	//closing off the xml document
	fwrite($xm, "</league>\n");
	fwrite($xm, "</sport>\n");
	
	//writing the dtd document
	fwrite($dt, "<!ELEMENT SPORT (LEAGUE*)>\n");
	fwrite($dt, "<!ELEMENT LEAGUE (LEAGUENUM+, TEAM*)>\n");
	fwrite($dt, "<!ELEMENT LEAGUENUM (#PCDATA)>\n");
	fwrite($dt, "<!ELEMENT TEAM (TEAMID+, TEAMNAME+, WINS*, LOSSES*)>\n");
	fwrite($dt, "<!ELEMENT TEAMID (#PCDATA)>\n");
	fwrite($dt, "<!ELEMENT TEAMNAME (#PCDATA)>\n");
	fwrite($dt, "<!ELEMENT WINS (#PCDATA)>\n");
	fwrite($dt, "<!ELEMENT LOSSES (#PCDATA)>\n");

	//writing the xsl document
	fwrite($xs, "<xsl:template match='/'>\n");
	fwrite($xs, "<html>\n");
	fwrite($xs, "<head>\n");
 	fwrite($xs, "<link href='lab2.css' rel='stylesheet' type='text/css'/>\n");
 	fwrite($xs, "</head>\n");
	fwrite($xs, "<body>\n");
 	fwrite($xs, "<h1 align='center'>Joshua Burkhart's CS 371 Lab 6</h1>\n");
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
	fwrite($xs, "<br></br>\n");
	fwrite($xs, "<xsl:for-each select='sport/league'>\n");
	fwrite($xs, "<table align='center' border='1'>\n");
	fwrite($xs, "<tr bgcolor='#FF7F24'><td>ID</td><td>Name</td><td>Wins</td><td>Losses</td></tr>\n");
	fwrite($xs, "<xsl:for-each select='team'>\n");
	fwrite($xs, "<tr bgcolor='FFFFFF'>\n");
	fwrite($xs, "<td><xsl:value-of select='teamId'/></td>\n");
	fwrite($xs, "<td><xsl:value-of select='teamName'/></td>\n");
	fwrite($xs, "<td><xsl:value-of select='wins'/></td>\n");
	fwrite($xs, "<td><xsl:value-of select='losses'/></td>\n");
	fwrite($xs, "</tr>\n");
	fwrite($xs, "</xsl:for-each>\n");
	fwrite($xs, "</table><br></br>\n");
	fwrite($xs, "</xsl:for-each>\n");
	fwrite($xs, "</body>\n");
	fwrite($xs, "</html>\n");
	fwrite($xs, "</xsl:template>\n");
	fwrite($xs, "</xsl:stylesheet>\n");
}//end else					

fclose($xm);
fclose($xs);
fclose($dt);
fclose($fp);

header("Location: fdoc.xml");
exit;

?>
