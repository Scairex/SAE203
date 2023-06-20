<!DOCTYPE html>
<html>
<head>
    <title>Affichage des données de la base de données</title>
</head>
<body>
    <h1>Données utilisateur</h1>

<?php
$servername = "localhost"; // Nom de l'hôte
$username = " victor.briaux"; // Nom d'utilisateur de la base de données
$password = "22207631"; // Mot de passe de la base de données
$dbname = "victor.briaux"; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
$sql = "SELECT * FROM earthquakes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Boucle sur chaque ligne de données
    while ($row = $result->fetch_assoc()) {
        // Traitez les données ici
    }
} else {
    echo "Aucune donnée trouvée.";
}

// Fermeture de la connexion
$conn->close();

echo "<table>";
echo "<tr><th>ID</th><th>Nom</th><th>Email</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['impact.gap'] . "</td>";
    echo "<td>" . $row['impact_magnitude'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>

</body>
</html>