<?php
	header("Access-Control-Allow-Origin: *");
	mb_internal_encoding("UTF-8");
	
	isset($_GET['id']) ? $id = $_GET['id'] : $id = null;
	isset($_GET['new']) ? $new = $_GET['new'] : $new = null;
	isset($_GET['token']) ? $token = $_GET['token'] : $token = null;
	
	if($id == null || $token == null || $new == null) die();
	
	$user = "root";
	$pass = "";
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$sql = 'SELECT * from profil WHERE token = :token';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':token' => $token));
	$profil = $sth->fetch();
	
	if($profil['admin'] == 1){
		$sql = 'UPDATE fiches SET id_creator = :new WHERE id = :id';//SET token = :token, last_token = :end WHERE login = :login';
		$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':id' => $id, ':new' => $new));

		echo '{"success":"Créateur mis à jour"}';
	}else{
		echo '{"error":"Vous devez disposer des droits d\'administrateur"}';
	}
?>