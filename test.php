<!DOCTYPE html>
<html>
<head>
    <title>Affichage des données de la base de données</title>
</head>
<body>
    <h1>Données utilisateur</h1>

<?php
$servername = "localhost"; // Nom de l'hôte
$username = "terence.bayle"; // Nom d'utilisateur de la base de données
$password = "22204880"; // Mot de passe de la base de données
$dbname = "terence.bayle"; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    
   
die("La connexion a échoué : " . $conn->connect_error);
}

$sql = "SELECT * FROM earthquakes";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table>"; 
echo "<tr><th>ID</th><th>Impact Gap</th><th>Impact Magnitude</th></tr>";

    // Boucle sur chaque ligne de données  
while ($row = $result->fetch_assoc()) {  

echo "<tr>";    
echo "<td>" . $row['id'] . "</td>";   
echo "<td>" . $row['impact.gap'] . "</td>";
echo "<td>" . $row['impact_magnitude'] . "</td>";     
echo "</tr>";
    }

    echo "</table>";
} else {   
echo "Aucune donnée trouvée.";
}

// Réinitialisation du curseur de résultat
$result->data_seek(0);
// Fermeture de la connexion
$conn->close();
?>

</body>
</html> 