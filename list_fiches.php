<?php
	header("Access-Control-Allow-Origin: *");
	
	$user = "root";
	$pass = "";
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$numberMax = $dbh->query('SELECT COUNT(id) as "count" from fiches')->fetch()['count'];
	$number = 0;
	
	echo '[';
    foreach($dbh->query('SELECT * from fiches') as $row) {
		$number++;
        if(file_exists('./fiches/'.$row['url'])){
			$result = file_get_contents('./fiches/'.$row['url']);
			$perso = json_decode($result, true);
			echo '{';
			echo '"id":'.$perso["id"].',';
			echo '"prenom":"'.$perso["prenom"].'",';
			echo '"nom":"'.$perso["nom"].'",';
			echo '"creator":"'.$row["id_creator"].'"';
			echo '}';
			if($number < $numberMax) echo ',';
		}
    }
	echo ']';
?>