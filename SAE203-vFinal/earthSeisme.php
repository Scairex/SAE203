<!DOCTYPE html>
<html>
<head>
    <title>Cesium Map</title>
    <link href="https://cesium.com/downloads/cesiumjs/releases/1.106/Build/Cesium/Widgets/widgets.css" rel="stylesheet">
</head>
<body>
    <div id="cesiumContainer"></div>
    <script src="https://cesium.com/downloads/cesiumjs/releases/1.84/Build/Cesium/Cesium.js"></script>

    <script>
        // Set your Cesium ion access token here
        Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI2MGYzMzY4My1iNDJkLTQ5N2UtODAxYi1mOTI2YTliZDlmMGIiLCJpZCI6MTQ4NTQ2LCJpYXQiOjE2ODc0NDgzNTB9.24CcgUb3iJ5V9ZU1qsBeZDn2wGXMc3STuLaUL2HP8fs';

        // Create a Cesium viewer
        var viewer = new Cesium.Viewer('cesiumContainer', {
            shouldAnimate: true,
            animation: false,
            timeline: false,
        });

        // Function to add a point at a given latitude and longitude
        function addPoint(latitude, longitude, size, color) {
            viewer.entities.add({
                position: Cesium.Cartesian3.fromDegrees(longitude, latitude),
                point: {
                    pixelSize: size,
                    color: color
                }
            });
        }
    </script>

    <?php
        $conn = mysqli_connect("localhost:13306", "root", "", "tpbdd") or die("Connexion non possible! <br/>". mysqli_connect_error());
        $requete = "SELECT location_latitude, location_longitude FROM earthquakes"; // Limite l'affichage à 10 points
        $resultat = mysqli_query($conn, $requete);

        if (!$resultat) {
            die("Erreur lors de l'exécution de la requête: " . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_assoc($resultat)) {
            echo "<script>addPoint($row[location_latitude], $row[location_longitude], 10, Cesium.Color.PURPLE);</script>";
        }
    ?>
</body>
</html>
