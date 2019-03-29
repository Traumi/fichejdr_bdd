<?php
	header("Access-Control-Allow-Origin: *");
	mb_internal_encoding("UTF-8");
	
	isset($_GET['id']) ? $id = $_GET['id'] : $id = null;
	
	isset($_GET['token']) ? $token = $_GET['token'] : $token = null;
	
	if($id == null || $token == null) die();
	
	$user = "root";
	$pass = "";
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$sql = 'SELECT * from profil WHERE token = :token';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':token' => $token));
	$profil = $sth->fetch();
	
	$sql = 'SELECT * from fiches WHERE id = :id';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':id' => $id));
	$url = $sth->fetch()['url'];
	
	if($profil['admin'] == 1){
		$sql = 'DELETE FROM fiches WHERE id = :id';//SET token = :token, last_token = :end WHERE login = :login';
		$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':id' => $id));
		//echo $url;
		unlink("./fiches/".$url);
	}
?>