<html>
	<head>

	</head>
	<body>
		<nav>

		</nav>
		<div>
			<?php
				$result = file_get_contents('./fiches/number.json');
				$number = json_decode($result, true)["number"];
				for($i = 0 ; $i < $number ; $i++){
					$result = file_get_contents('./fiches/'.$i.'.json');
					$perso = json_decode($result, true);
					//var_dump($perso);
					echo '<a href="./detail.php?n='.$i.'">Fiche de '.$perso["Prenom"].'</a>';
					echo '<br/>';
				}
			?>
		</div>
		<footer>

		</footer>
	</body>
</html>