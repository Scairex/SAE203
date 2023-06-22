<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si les choix ont été soumis
    if (isset($_POST["choix1"]) && isset($_POST["choix2"])) {
        $choix1 = $_POST["choix1"];
        $choix2 = $_POST["choix2"];

        // Activer le fichier PHP correspondant aux sélections de l'utilisateur
        if ($choix1 === "option1") {
            if ($choix2 === "choixA") {
                header("Location: ajoutSeisme.php");
                exit();
            } elseif ($choix2 === "choixB") {
                header("Location: modifSeisme.php");
                exit();
            } elseif ($choix2 === "choixC") {
                header("Location: supprSeisme.php");
                exit();
            } else {
                echo "Choix invalide pour le deuxième menu déroulant.";
            }
        } elseif ($choix1 === "option2") {
            if ($choix2 === "choixA") {
                header("Location: ajoutMeteorite.php");
                exit();
            } elseif ($choix2 === "choixB") {
                header("Location: modifMeteorite.php");
                exit();
            } elseif ($choix2 === "choixC") {
                header("Location: supprMeteorite.php");
                exit();
            } else {
                echo "Choix invalide pour le deuxième menu déroulant.";
            }
        } elseif ($choix1 === "option3") {
            if ($choix2 === "choixA") {
                header("Location: ajoutPays.php");
                exit();
            } elseif ($choix2 === "choixB") {
                header("Location: modifPays.php");
                exit();
            } elseif ($choix2 === "choixC") {
                header("Location: supprPays.php");
                exit();
            } else {
                echo "Choix invalide pour le deuxième menu déroulant.";
            }
        } else {
            echo "Choix invalide pour le premier menu déroulant.";
        }
    } else {
        echo "Aucun choix n'a été fait.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>