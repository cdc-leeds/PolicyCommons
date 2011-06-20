<?php
/*
 * This update will add one column IsGroup into Users table
 * and update its value for existing tables 
 * 
 * 22/01/09 by Gary Li , Fixed by Michelle Bachler 3rd Novenmber 2009
 */

include_once("../config.php");


echo "Update ......\n";
        
$qry = "ALTER TABLE Users ADD COLUMN IsGroup enum('N','Y') NOT NULL DEFAULT 'N' AFTER IsAdministrator";
$res = mysql_query($qry, $DB->conn);
if (!$res) {
	echo ("Alter Table user adding IsGroup has an error! ". $res); 
}else{
            
	$qry = "UPDATE Users SET IsGroup='Y' WHERE Users.UserID IN (Select Distinct GroupID from UserGroup)";
	$res = mysql_query($qry, $DB->conn);
	if (!$res) {
		echo ("Update Users IsGroup has an error! ". $res); 
	}else{           
		echo "Updated users with IsGroup has been done. ";
	}
}          
?>