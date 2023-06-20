<HTML>
	<meta charset="utf-8"/>
	<BODY>
<?php

//Essai de connexion au serveur local sur le port 13306 avec comme userid root et password une chaîne vide
$conn=mysqli_connect("localhost", "victor.briaux","22207631","victor.briaux") or die("Connexion non possible! <br/>". mysqli_connect_error());;
echo "Liste des utilisateurs<br/>";
$requete = 'SELECT * FROM earthquakes';
$statement =mysqli_prepare($conn, $requete) or die(mysqli_error($conn));
//mysqli_stmt_bind_param($statement,"sss",$pseudo,$pass,$email) or die(mysqli_error($conn));
mysqli_execute($statement) or die(mysqli_error($conn));
$resultat=mysqli_stmt_get_result($statement);
//affichage table https://www.w3schools.com/html/tryit.asp?filename=tryhtml_table_intro
while($row = mysqli_fetch_array($resultat, MYSQLI_ASSOC))
{
    echo($row['id']." ".$row['impact.gap']);
    echo ("<br/>");
}
mysqli_close($conn) or die(mysqli_error($conn));
?>
</BODY>
</HTML>