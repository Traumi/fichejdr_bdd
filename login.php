<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT");
	header("Access-Control-Allow-Headers: Content-Type");
	
	//$postdata = file_get_contents("php://input");
	
	$pw = $_GET['pw'];
	$login = $_GET['login'];
	
	$options = [
		'cost' => 12,
	];
	
	$user = "root";
	$pass = "";
	
	echo '{';
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
		
		$sql = 'SELECT * from profil WHERE login = :login';
		$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':login' => $login));
		$res = $sth->fetch();
		
		if(password_verify($pw, $res['pw'])){
			//Generate a random string.
			$token = openssl_random_pseudo_bytes(16);
			 
			//Convert the binary data into hexadecimal representation.
			$token = bin2hex($token);
			
			$date = date("Y").'-'.date("m").'-'.date("d"); 
			$token_end = strtotime("+5 day", strtotime($date));
			$token_end = date('Y-m-d',$token_end);
			
			$sql = 'UPDATE profil SET token = :token, last_token = :end WHERE login = :login';
			$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':login' => $res['login'], ':token' => $token, ':end' => $token_end));
			
			echo '"login":"'.$login.'","token":"'.$token.'"';
		}else{
			echo '"error":"Pseudo ou mot de passe incorrect"';
		}
		
		$dbh = null;
	} catch (PDOException $e) {
		echo '"error":"database:'.$e.'"';
		die();
	}
	echo '}';
?>