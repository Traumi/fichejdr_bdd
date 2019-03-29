<?php
	header("Access-Control-Allow-Origin: *");
	
	isset($_GET['id']) ? $id = $_GET['id'] : $id = 0;
	
	$user = "root";
	$pass = "";
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$sql = 'SELECT * from fiches WHERE id = :id';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':id' => $id));
	$res = $sth->fetch();
	
	require_once('./fiches/'.$res['url']);
?>