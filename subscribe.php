<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT");
	header("Access-Control-Allow-Headers: Content-Type");
	
	//$postdata = file_get_contents("php://input");
	
	$login = trim($_GET['login']);
	$pw = trim($_GET['pw']);
	
	if(strtolower($login) == "null"){
		die();
	}
	
	$options = [
		'cost' => 12,
	];
	$pw = password_hash($pw, PASSWORD_BCRYPT, $options);
	
	$user = "root";
	$pass = "";
	
	
	
	echo '{';
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
		
		$sql = 'SELECT * from profil WHERE login = :login';
		$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':login' => $login));
		if($sth->fetch()){ echo ('"error":"Ce compte existe déjà"');}
		else{
			$stmt = $dbh->prepare("INSERT INTO profil(login, pw, last_token, token) VALUES (:login,:pw,NULL,NULL)");
			$stmt->bindParam(':login', $login);
			$stmt->bindParam(':pw', $pw);
			$stmt->execute();
			
			//Generate a random string.
			$token = openssl_random_pseudo_bytes(16);
			 
			//Convert the binary data into hexadecimal representation.
			$token = bin2hex($token);
			
			$date = date("Y").'-'.date("m").'-'.date("d"); 
			$token_end = strtotime("+5 day", strtotime($date));
			$token_end = date('Y-m-d',$token_end);
			
			$sql = 'UPDATE profil SET token = :token, last_token = :end WHERE login = :login';
			$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':login' => $login, ':token' => $token, ':end' => $token_end));
			
			echo '"login":"'.$login.'","token":"'.$token.'"';
		}
		$dbh = null;
		
	} catch (PDOException $e) {
		echo '"error":"database:'.$e.'"';
	}
	echo '}';
?>