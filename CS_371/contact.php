<?php
$to = 'joshuagburkhart@gmail.com';
$subject = "CorporeateEAR_Contact";
$email = $_POST['Email_Address'];
$name = $_POST['Name'];
$phone = $_POST['Phone_Number'];
$additional_information = $_POST['Additional_Information'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$geoLocation = "http://www.ip2location.com/" . $ipaddress;
$headers = " IP Address: $ipaddress \n Location: $geoLocation \n Email: $email \n Name: $name \n Phone Number: $phone \n Additional Information: $additional_information";
mail($to, $subject, $headers, "From: contact@CorporateEAR.com");
header("Location: contactsuccess.html");
?> 
