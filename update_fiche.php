<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT");
	header("Access-Control-Allow-Headers: Content-Type");
	
	$user = "root";
	$pass = "";
	
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$sql = 'SELECT * from fiches WHERE id = :id';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':id' => $request['id']));
	$res = $sth->fetch();
	
	$file = fopen("./fiches/".$res['url'], "w");
	fwrite($file, $postdata);
	fclose($file);
?>