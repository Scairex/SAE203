<!DOCTYPE html>

<html>

<head>
    <title>Example 01.04 - Materials, light and animation</title>
    <script type="text/javascript" src="./libs/three/three.js"></script>
    <script type="text/javascript" charset="UTF-8" src="./libs/three/controls/TrackballControls.js"></script>
    <script type="text/javascript" src="./libs/util/dat.gui.js"></script>
    <script type="text/javascript" src="./libs/three/utils/SceneUtils.js"></script>
    <script type="text/javascript" src="./libs/util/dat.gui.js"></script>
    <script type="text/javascript" src="./fctEarth.js"></script>

    <!-- ajout de la lib leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <style>
        body {
            /* set margin to 0 and overflow to hidden, to go fullscreen */
            margin: 0;
            overflow: hidden;
        }
        
        #WebGL-output {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        
        #popup {
            position: absolute;
            display: none;
            width: 300px;
            height: 200px;
            background-color: white;
            border: 1px solid black;
            z-index: 1;
            padding: 20px;
            font-family: Arial, sans-serif;
            border-radius: 15px;
        }
    </style>
</head>

<body>

    <div id="Stats-output">
    </div>
    <!-- Div which will hold the Output -->
    <div id="WebGL-output">
    </div>

    <div id="popup"></div>

<?php
//Essai de connexion au serveur local sur le port 13306 avec comme userid root et password une chaîne vide
$conn=mysqli_connect("localhost:13306", "root","root","TPBDD") or die("Connexion non possible! <br/>". mysqli_connect_error());
echo "Connexion valide.<br/>";

$requete = 'SELECT * FROM earthquakes';
$statement =mysqli_prepare($conn, $requete) or die(mysqli_error($conn));
//mysqli_stmt_bind_param($statement,"sss",$pseudo,$pass,$email) or die(mysqli_error($conn));
mysqli_stmt_execute($statement) or die(mysqli_error($conn));
$resultat=mysqli_stmt_get_result($statement);
//affichage table https://www.w3schools.com/html/tryit.asp?filename=tryhtml_table_intro

while($row = mysqli_fetch_array($resultat, MYSQLI_ASSOC))
{
    echo($row['location_latitude']." ".$row['location_longitude']);
    echo ("<br/>");
   $res[]=$row;

}
// Passer le tableau $res à un code js.
$t=json_encode($res);
mysqli_close($conn) or die(mysqli_error($conn));
?>

<script>
    
dataBDD  = JSON.parse('<?php echo($t);?>');

// appel de l'affichage
document.addEventListener("DOMContentLoaded", function() {
    init();
});

</script>

</body>

</html>