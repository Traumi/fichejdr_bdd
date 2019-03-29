<html>
	<head>

	</head>
	<body>
		<nav>

		</nav>
		<div>
			<?php
				$result = file_get_contents('./fiches/'.$_GET["n"].'.json');
				$perso = json_decode($result, true);
				//var_dump($perso);
				//echo '<a href="./detail.php?n='.$i.'">Fiche de '.$perso["Prenom"].'</a>';
				//echo '<br/>';
			?>
			<div>
				<h3>Fiche de <?php echo $perso["Prenom"]." ".$perso["Nom"] ?></h3>
				<div>
					<?php
						foreach ($perso["Stats"] as $key => $value) {
							echo $key.' : '.$value.'<br/>';
						}
					?>
					<?php
						foreach ($perso["Bars"] as $key => $value) {
							echo $key.' : '.$value.'<br/>';
						}
					?>
				</div>
				<div>
					<?php
						/*
							Coût, Nom, Effet, Element
						*/
						foreach ($perso["Compétences"] as $comp) {
							foreach ($comp as $key => $value) {
								echo $key.' : '.$value.'<br/>';
							}
						}
					?>
				</div>
				<div>
					<?php
						foreach ($perso["Stuff"] as $item) {
							foreach ($item as $key => $value) {
								echo $key.' : '.$value.'<br/>';
							}
						}
					?>
				</div>
			</div>
		</div>
		<footer>

		</footer>
	</body>
</html>