<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT");
	header("Access-Control-Allow-Headers: Content-Type");
	
	//$postdata = file_get_contents("php://input");
	
	$token = $_GET['token'];
	//$login = $_GET['login'];
	
	if($token == "" || $token == null){
		echo '"error":"wrong token"';
		die();
	}
	
	$options = [
		'cost' => 12,
	];
	
	$user = "root";
	$pass = "";
	
	echo '{';
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
		
		$sql = 'SELECT * from profil WHERE token = :token';
		$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':token' => $token));
		$res = $sth->fetch();
		
		if($res){
			$date = date("Y").'-'.date("m").'-'.date("d"); 
			$token_end = strtotime("+5 day", strtotime($date));
			$token_end = date('Y-m-d',$token_end);
			
			$sql = 'UPDATE profil SET last_token = :end WHERE token = :token';
			$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':token' => $token, ':end' => $token_end));

			echo '"login":"'.$res['login'].'", "token":"'.$res['token'].'", "admin":"'.$res['admin'].'"';
		}
		else{
			echo '"error":"wrong token"';
		}
		
		$dbh = null;
	} catch (PDOException $e) {
		echo '"error":"database:'.$e.'"';
		die();
	}
	echo '}';
?>