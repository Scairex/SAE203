<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    </head>
    <body>
        <?php

        // Essai de connexion au serveur local sur le port 13306 avec comme userid root et password une chaîne vide
        $conn = mysqli_connect("localhost:13306", "root", "", "tpbdd") or die("Connexion non possible! <br/>". mysqli_connect_error());
        echo "Liste des séismes<br/>";

        // Récupération de la liste des colonnes de la table meteorites
        $requete_colonnes = "SHOW COLUMNS FROM meteorites";
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
            $requete = "SELECT * FROM meteorites";
            if ($afficherInterval) {
                $requete .= " WHERE $colonne BETWEEN $debut AND $fin";
            }
            $requete .= " LIMIT 100";

            // Exécution de la requête
            $resultat = mysqli_query($conn, $requete) or die(mysqli_error($conn));

            // Vérification s'il y a des résultats
            if (mysqli_num_rows($resultat) > 0) {
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
                }

                echo '</tbody>
                    </table>';
            } else {
                echo "Aucune donnée trouvée.";
            }

            // Libération des ressources
            mysqli_free_result($resultat);
        }

        // Fonction pour afficher une ligne du tableau
        function affichRow($row, $colonnes) {
            echo "<tr>";
            foreach ($colonnes as $col) {
                echo "<td>".$row[$col]."</td>";
            }
            echo "</tr>";
        }

        // Suppression de données
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["deleteData"])) {
            $condition = "";
            $colonne = $_POST["deleteColonne"];
            $valeur = $_POST["deleteValeur"];

            if (in_array($colonne, $colonnes)) {
                $condition = "$colonne = '$valeur'";
            }

            if (!empty($condition)) {
                $requeteDelete = "DELETE FROM meteorites WHERE $condition";
                mysqli_query($conn, $requeteDelete) or die(mysqli_error($conn));

                // Actualisation de la page
                echo '<script>window.location.href = window.location.href;</script>';
            }
        }

        mysqli_close($conn) or die(mysqli_error($conn));
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

        <h2>Supprimer des valeurs :</h2>
        <form method="POST" action="">
            <label for="deleteColonne">Choisir une colonne :</label>
            <select name="deleteColonne" required>
                <?php
                foreach ($colonnes as $col) {
                    echo "<option value=\"$col\">$col</option>";
                }
                ?>
            </select>
            <br>
            <label for="deleteValeur">Valeur :</label>
            <input type="text" name="deleteValeur" required>
            <br>
            <button type="submit" name="deleteData">Supprimer</button>
        </form>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#datatable').DataTable();
            });
        </script>
    </body>
</html>
