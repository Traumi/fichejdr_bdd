<?php
	header("Access-Control-Allow-Origin: *");
	
	$user = "root";
	$pass = "";
	
	$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	
	$numberMax = $dbh->query('SELECT COUNT(login) as "count" from profil')->fetch()['count'];
	$number = 0;
	
	echo '[';
    foreach($dbh->query('SELECT * from profil') as $row) {
		$number++;
        echo '{';
		echo '"login":"'.$row["login"].'",';
		echo '"admin":'.$row["admin"].'';
		echo '}';
		if($number < $numberMax) echo ',';
    }
	echo ']';
?>