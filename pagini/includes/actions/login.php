<?php
	include ('../config.php');
	include ('../classes/dbconnect.php');
	ini_set ("display_errors", 0);
	if (isset($_GET["action"]) && $_GET["action"] == "login") {
		$get_user = $database->select("SELECT * FROM users WHERE `email` = '".$_POST['email']."' AND `password` = '".md5($_POST['password'])."' AND `status` = '1'");
		
		$userdata = $database->assoc($get_user);
		if ($get_user) {
			setcookie("u_id", $userdata["id"], time() + (86400 * 30), "/"); // 86400 = 1 day
			echo 1;
			
		} else {
			echo 0;	
			
		}
		
	}

?>