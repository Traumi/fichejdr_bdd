<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT");
	header("Access-Control-Allow-Headers: Content-Type");
	
	//$postdata = file_get_contents("php://input");
	
	$token = $_GET['token'];
	$id = $_GET['id'];
	
	if($token == "" || $token == null){
		echo '"error":"wrong token"';
		die();
	}
	//$login = $_GET['login'];
	
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
			/*$date = date("Y").'-'.date("m").'-'.date("d"); 
			$token_end = strtotime("+5 day", strtotime($date));
			$token_end = date('Y-m-d',$token_end);
			
			$sql = 'UPDATE profil SET last_token = :end WHERE token = :token';
			$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':token' => $token, ':end' => $token_end));*/
			
			if($res['admin'] == 1){
				echo '"login":"'.$res['login'].'", "token":"'.$res['token'].'"';
			}else{
				$sql = 'SELECT * from fiches WHERE id = :id';
				$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
				$sth->execute(array(':id' => $id));
				$perso = $sth->fetch();
				if($perso['id_creator'] == $res['login']){
					echo '"login":"'.$res['login'].'", "token":"'.$res['token'].'"';
				}else{
					echo '"error":"access not granted"';
				}
			}
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