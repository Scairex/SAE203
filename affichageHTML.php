<html>
	<meta charset="utf-8"/>
	<body>
		<?php

		// Essai de connexion au serveur local sur le port 13306 avec comme userid root et password une chaîne vide
		$conn = mysqli_connect("localhost:13306", "root", "", "sae203") or die("Connexion non possible! <br/>". mysqli_connect_error());
		echo "Liste des séismes<br/>";
		$requete = 'SELECT * FROM earthquakes';
		$statement = mysqli_prepare($conn, $requete) or die(mysqli_error($conn));
		mysqli_stmt_execute($statement) or die(mysqli_error($conn));
		$resultat = mysqli_stmt_get_result($statement);
		?>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Gap</th>
					<th>Magnitude</th>
					<th>Significance</th>
					<th>locationdepth</th>
			 		<th>locationdistance</th>
			 		<th>locationfull</th>
			 		<th>location_latitude</th>
			 		<th>location_longitude</th>
			 		<th>locationname</th>
					<th>timeday</th>
			 		<th>timeepoch</th>
			 		<th>timefull</th>
			 		<th>timehour</th>
			 		<th>timeminute</th>
			 		<th>timemonth</th>
			 		<th>timesecond</th>
			 		<th>timeyear</th>
				</tr>
			</thead>

			<tbody>
				<?php
				while ($row = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
					affichRow($row);
				}
				?>
			</tbody>
		</table>

		<?php
		mysqli_close($conn) or die(mysqli_error($conn));

		// Fonction pour afficher une ligne du tableau
		function affichRow($row) {
			echo "<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['impactgap']."</td>";
			echo "<td>".$row['impact_magnitude']."</td>";
			echo "<td>".$row['impactsignificance']."</td>";
			echo "<td>".$row['locationdepth']."</td>";
			echo "<td>".$row['locationdistance']."</td>";
			echo "<td>".$row['locationfull']."</td>";
			echo "<td>".$row['location_latitude']."</td>";
			echo "<td>".$row['location_longitude']."</td>";
			echo "<td>".$row['locationname']."</td>";
			echo "<td>".$row['timeday']."</td>";
			echo "<td>".$row['timeepoch']."</td>";
			echo "<td>".$row['timefull']."</td>";
			echo "<td>".$row['timehour']."</td>";
			echo "<td>".$row['timeminute']."</td>";
			echo "<td>".$row['timemonth']."</td>";
			echo "<td>".$row['timesecond']."</td>";
			echo "<td>".$row['timeyear']."</td>";
			echo "</tr>";
		}
		?>

	</body>
</html>
