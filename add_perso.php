<?php
	header("Access-Control-Allow-Origin: *");
	mb_internal_encoding("UTF-8");
	
	isset($_GET['p']) ? $prenom = $_GET['p'] : $prenom = "Dummy";
	isset($_GET['n']) ? $nom = $_GET['n'] : $nom = "";
	isset($_GET['c']) ? $crea = $_GET['c'] : $crea = "";
	
	$user = "root";
	$pass = "";
	
	$url = trim(strtolower($prenom)).'_'.trim(strtolower($nom)).'.json';
	if(file_exists("./fiches/".$url)){
		$i = 1;
		while(file_exists("./fiches/".trim(strtolower($prenom)).'_'.trim(strtolower($nom)).'_'.$i.'.json')){
			$i++;
		}
		$url = trim(strtolower($prenom)).'_'.trim(strtolower($nom)).'_'.$i.'.json';
	}
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$sql = 'SELECT * from profil WHERE token = :token';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':token' => $crea));
	$profil = $sth->fetch();
	
	$sql = 'INSERT INTO fiches (url, id_creator) VALUES (:url, :crea)';//SET token = :token, last_token = :end WHERE login = :login';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':url' => $url, ':crea' => $profil['login']));
	
	$sql = 'SELECT * from fiches WHERE url = :url';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':url' => $url));
	$res = $sth->fetch();
	
	$new_perso = '{"id":'.$res["id"].',"prenom":"'.$prenom.'","nom":"'.$nom.'","age":0,"race":"","classe":"","stats":[],"bars":[],"stuff":[],"armures":[],"objets":[],"competences":[]}';
	
	$file = fopen("./fiches/".$url, "w");
	fwrite($file, $new_perso);
	fclose($file);
	
	echo '{"test":"ok"}';
?>