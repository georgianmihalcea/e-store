<?php
	include ('../config.php');
	include ('../classes/dbconnect.php');
	
	//Insert into database
	if (isset($_GET['action']) && $_GET['action'] == 'add_user') {
	$username = $_POST['username'];	
	$f_name = $_POST['f_name'];
	$l_name = $_POST['l_name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$json = array();
	$insert_user = $database->execute("INSERT INTO users (`username`, `name`, `lastname`, `password`, `email`, `phone`,	`status`) VALUES 
	('".$username."', '".$f_name."', '".$l_name."', '".$password."', '".$email."', '".$phone."', 1)");
	
		if ($insert_user['status'] == 1){
			$json['status'] = 1;
			$json['message'] = 'Utilizatorul a fost adaugat cu success';
		}else{
			$json['status'] = 0;
			$json['message'] = 'Utilizatorul nu a fost adaugat, eroare:'.$insert_user['error'].'; eroare de inregistrare.';
		}
		echo json_encode($json);
	}




?>