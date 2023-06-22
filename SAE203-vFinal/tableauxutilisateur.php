<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si les choix ont été soumis
    if (isset($_POST["choix1"]) && isset($_POST["choix2"])) {
        $choix1 = $_POST["choix1"];
        $choix2 = $_POST["choix2"];

        // Activer le fichier PHP correspondant aux sélections de l'utilisateur
        if ($choix1 === "option1") {
            if ($choix2 === "choixA") {
                header("Location: seismets.php");
                exit();
            } elseif ($choix2 === "choixB") {
                header("Location: seismeti.php");
                exit();
            } elseif ($choix2 === "choixC") {
                header("Location: earthSeisme.php");
                exit();
            } else {
                echo "Choix invalide pour le deuxième menu déroulant.";
            }
        } elseif ($choix1 === "option2") {
            if ($choix2 === "choixA") {
                header("Location: meteoritets.php");
                exit();
            } elseif ($choix2 === "choixB") {
                header("Location: meteoriteti.php");
                exit();
            } elseif ($choix2 === "choixC") {
                header("Location: earthMeteorite.php");
                exit();
            } else {
                echo "Choix invalide pour le deuxième menu déroulant.";
            }
        } elseif ($choix1 === "option3") {
            if ($choix2 === "choixA") {
                header("Location: paysts.php");
                exit();
            } elseif ($choix2 === "choixB") {
                header("Location: paysti.php");
                exit();
            } elseif ($choix2 === "choixC") {
                header("Location: earthPays.php");
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

