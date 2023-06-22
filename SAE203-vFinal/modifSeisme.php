<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
</head>
<body>
    <?php

    // Essai de connexion au serveur local sur le port 13306 avec comme userid root et password une chaîne vide
    $conn = mysqli_connect("localhost:13306", "root", "", "tpbdd") or die("Connexion non possible! <br/>". mysqli_connect_error());
    echo "Liste des pays<br/>";

    // Récupération de la liste des colonnes de la table earthquakes
    $requete_colonnes = "SHOW COLUMNS FROM earthquakes";
    $resultat_colonnes = mysqli_query($conn, $requete_colonnes) or die(mysqli_error($conn));
    $colonnes = array();
    
    while ($row_colonne = mysqli_fetch_array($resultat_colonnes)) {
        $colonnes[] = $row_colonne['Field'];
    }

    // Vérification de la soumission du formulaire
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupération des valeurs du formulaire
        $colonne = $_POST["colonne"];
        $afficherInterval = isset($_POST["afficherInterval"]);
        $debut = $_POST["debut"];
        $fin = $_POST["fin"];

        // Construction de la requête SQL
        $requete = "SELECT * FROM earthquakes";
        if ($afficherInterval) {
            $requete .= " WHERE $colonne BETWEEN $debut AND $fin";
        }

        // Exécution de la requête
        $resultat = mysqli_query($conn, $requete) or die(mysqli_error($conn));

        // Vérification s'il y a des résultats
        if (mysqli_num_rows($resultat) > 0) {
            echo '<form method="POST" action="">';
            echo '<table id="datatable">
                <thead>
                    <tr>';
            
            // Affichage des en-têtes de colonne
            foreach ($colonnes as $col) {
                echo "<th>$col</th>";
            }
            
            echo '</tr>
                </thead>
                <tbody>';

            // Affichage des données
            while ($row = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                affichRow($row, $colonnes);
                editRow($row, $colonnes);
            }

            echo '</tbody>
                </table>';
            echo '<button type="submit">Enregistrer les modifications</button>';
            echo '</form>';
        } else {
            echo "Aucune donnée trouvée.";
        }

        // Libération des ressources
        mysqli_free_result($resultat);
    }

    mysqli_close($conn) or die(mysqli_error($conn));

    // Fonction pour afficher une ligne du tableau
    function affichRow($row, $colonnes) {
        echo "<tr>";
        foreach ($colonnes as $col) {
            echo "<td>".$row[$col]."</td>";
        }
        echo "</tr>";
    }

    // Fonction pour afficher une ligne du tableau en mode édition
    function editRow($row, $colonnes) {
        echo "<tr>";
        foreach ($colonnes as $col) {
            echo "<td><input type='text' name='$col' value='".$row[$col]."'></td>";
        }
        echo "</tr>";
    }
    ?>

    <form method="POST" action="">
        <label for="colonne">Paramètre de l'intervalle :</label>
        <select name="colonne" required>
            <?php
            foreach ($colonnes as $col) {
                echo "<option value=\"$col\">$col</option>";
            }
            ?>
        </select>
        <br>
        <input type="checkbox" name="afficherInterval" id="afficherInterval">
        <label for="afficherInterval">Afficher l'intervalle de valeurs :</label>
        <br>
        <label for="debut">Début :</label>
        <input type="text" name="debut">
        <br>
        <label for="fin">Fin :</label>
        <input type="text" name="fin">
        <br>
        <button type="submit">Afficher</button>
    </form>
</body>
</html>
