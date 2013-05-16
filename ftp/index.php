<?php
session_start();

//setup db connection
$link = mysqli_connect("localhost","smartphy_physio","physiopassword");
mysqli_select_db($link, "smartphy_db");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//executes a given sql query with the params and returns an array as result
function query() {
	global $link;
	$debug = false;
	
	//get the sql query
	$args = func_get_args();
	$sql = array_shift($args);

	//secure the input
	for ($i=0;$i<count($args);$i++) {
		$args[$i] = urldecode($args[$i]);
		$args[$i] = mysqli_real_escape_string($link, $args[$i]);
	}
	
	//build the final query
	$sql = vsprintf($sql, $args);
	
	if ($debug) print $sql;
	
	//execute and fetch the results
	$result = mysqli_query($link, $sql);
	if (mysqli_errno($link)==0 && $result) {
		
		$rows = array();

		if ($result!==true)
		while ($d = mysqli_fetch_assoc($result)) {
			array_push($rows,$d);
		}
		
		//return json
		return array('result'=>$rows);
		
	} else {
	
		//error
		return array('error'=>'Database error');
	}
}

//loads up the source image, resizes it and saves with -thumb in the file name
function thumb($srcFile, $sideInPx) {

  $image = imagecreatefromjpeg($srcFile);
  $width = imagesx($image);
  $height = imagesy($image);
  
  $thumb = imagecreatetruecolor($sideInPx, $sideInPx);
  
  imagecopyresized($thumb,$image,0,0,0,0,$sideInPx,$sideInPx,$width,$height);
  
  imagejpeg($thumb, str_replace(".jpg","-thumb.jpg",$srcFile), 85);
  
  imagedestroy($thumb);
  imagedestroy($image);
}

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



header("Content-Type: application/json");

echo "TEST API for AFNETWORKING - iOS6";


switch ($_POST['command']) {
	case "login": 
		login($_POST['username'], $_POST['password']); break;
 
	case "register":
		register($_POST['username'], $_POST['password']); break;
 
}

exit();
?>