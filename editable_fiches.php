<?php
	header("Access-Control-Allow-Origin: *");
	
	$user = "root";
	$pass = "";
	
	$token = $_GET['token'];
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$sql = 'SELECT * from profil WHERE token = :token';
	$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$sth->execute(array(':token' => $token));
	$profil = $sth->fetch();
	echo '[';
	$number = 0;
	if($profil['admin'] == 1){
		$numberMax = $dbh->query('SELECT COUNT(id) as "count" from fiches')->fetch()['count'];
		
		foreach($dbh->query('SELECT * from fiches') as $row) {
			$number++;
			if(file_exists('./fiches/'.$row['url'])){
				$result = file_get_contents('./fiches/'.$row['url']);
				$perso = json_decode($result, true);
				echo '{';
				echo '"id":'.$perso["id"].',';
				echo '"prenom":"'.$perso["prenom"].'",';
				echo '"nom":"'.$perso["nom"].'"';
				echo '}';
				if($number < $numberMax) echo ',';
			}
		}
	}else{
		$sql = 'SELECT COUNT(id) as "count" from fiches WHERE id_creator = :name';
		$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':name' => $profil['login']));
		$numberMax = $sth->fetch()['count'];
		
		$sql = 'SELECT * from fiches WHERE id_creator = :name';
		$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':name' => $profil['login']));
		
		foreach($sth as $row) {
			$number++;
			if(file_exists('./fiches/'.$row['url'])){
				$result = file_get_contents('./fiches/'.$row['url']);
				$perso = json_decode($result, true);
				echo '{';
				echo '"id":'.$perso["id"].',';
				echo '"prenom":"'.$perso["prenom"].'",';
				echo '"nom":"'.$perso["nom"].'"';
				echo '}';
				if($number < $numberMax) echo ',';
			}
		}
	} 
	echo ']';
	
?>