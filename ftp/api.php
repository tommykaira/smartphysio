<?php
//API implementation to come here

function errorJson($msg){
	print json_encode(array('error'=>$msg));
	exit();
}

function register($user, $pass) {
	//check if username exists
	
	echo "User: " .$user;
	echo "Password: " .$pass;
	
	//check if username exists
	$login = query("SELECT username FROM login WHERE username='%s' limit 1", $user);
	if (count($login['result'])>0) {
		errorJson('Username already exists');
	}
	
	//try to register the user
	$result = query("INSERT INTO login(username, pass) VALUES('%s','%s')", $user, $pass);
	if (!$result['error']) {
		//success
		echo "success";
		login($user, $pass);
	} else {
		//error
		errorJson('Registration failed');
	}

}


function login($user, $pass) {
	$result = query("SELECT IdUser, username FROM login WHERE username='%s' AND pass='%s' limit 1", $user, $pass);
 
	if (count($result['result'])>0) {
		//authorized
		$_SESSION['IdUser'] = $result['result'][0]['IdUser'];
		print json_encode($result);
	} else {
		//not authorized
		errorJson('Authorization failed');
	}
}








?>