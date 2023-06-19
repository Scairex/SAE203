// once everything is loaded, we run our Three.js stuff.
function createSphere(radius, segments) {
    return new THREE.Mesh(
        new THREE.SphereGeometry(radius, segments, segments),
        new THREE.MeshPhongMaterial({
            map: THREE.ImageUtils.loadTexture('images/2_no_clouds_4k.jpg'),
            bumpMap: THREE.ImageUtils.loadTexture('images/elev_bump_4k.jpg'),
            bumpScale: 0.005,
            specularMap: THREE.ImageUtils.loadTexture('images/water_4k.png'),
            specular: new THREE.Color('grey')
        })
    );
}

function createClouds(radius, segments) {
    return new THREE.Mesh(
        new THREE.SphereGeometry(radius + 0.003, segments, segments),
        new THREE.MeshPhongMaterial({
            map: THREE.ImageUtils.loadTexture('images/fair_clouds_4k.png'),
            transparent: true
        })
    );
}

function createStars(radius, segments) {
    return new THREE.Mesh(
        new THREE.SphereGeometry(radius, segments, segments),
        new THREE.MeshBasicMaterial({
            map: THREE.ImageUtils.loadTexture(''),
            side: THREE.BackSide
        })
    );
}

function calcPosFromLatLonRad(lat, lon, radius) {
    var phi = (90 - lat) * (Math.PI / 180);
    var theta = (lon + 180) * (Math.PI / 180);

    x = -((radius) * Math.sin(phi) * Math.cos(theta));
    z = ((radius) * Math.sin(phi) * Math.sin(theta));
    y = ((radius) * Math.cos(phi));

    return [x, y, z];
}

function createSelectableObject(color, position) {
    const geometry = new THREE.SphereGeometry(0.004, 32, 32);
    const material = new THREE.MeshBasicMaterial({ color });
    const selectableObj = new THREE.Mesh(geometry, material);
    selectableObj.position.set(position[0], position[1], position[2]);
    selectableObj.userData.selectable = true; // Ajoute un marqueur pour les objets sélectionnables
    return selectableObj;
}

function createMoon(radius, segments) {
    const textureLoader = new THREE.TextureLoader();
    return new THREE.Mesh(
        new THREE.SphereGeometry(radius, segments, segments),
        new THREE.MeshPhongMaterial({
            map: textureLoader.load('images/moon_4k.jpg')
        })
    );
}

function createTriangle(color, position) {
    const geometry = new THREE.ConeGeometry(0.004, 0.01, 3);
    const material = new THREE.MeshBasicMaterial({ color });
    const triangle = new THREE.Mesh(geometry, material);
    triangle.position.set(position[0], position[1], position[2]);
    triangle.lookAt(new THREE.Vector3(0, 0, 0));
    triangle.userData.selectable = true;
    return triangle;
}

function updateMoonPosition() {
    const moonOrbitRadius = 1.5; // La distance de la Lune par rapport au point fixe (en unités arbitraires)
    const moonOrbitSpeed = 3 / 27.3; // La vitesse orbitale de la Lune autour du point fixe
    const angle = clock.getElapsedTime() * moonOrbitSpeed;

    moon.position.set(
        moonOrbitRadius * Math.cos(angle),
        0,
        moonOrbitRadius * Math.sin(angle)
    );
}

function onMouseClick(event) {
    event.preventDefault();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);
    const intersects = raycaster.intersectObjects(sphere.children);

    for (const intersect of intersects) {
        if (intersect.object.userData.selectable) {
            // Affiche un pop-up interne
            const popup = document.getElementById("popup");
            popup.style.display = "block";
            popup.style.left = event.clientX + "px";
            popup.style.top = event.clientY + "px";
            if (intersect.object.userData.name === "MOON") {
                popup.innerHTML = "Morceaux de la Terre : " + intersect.object.userData.name;
            }

            if (intersect.object.userData.name) {
                popup.innerHTML = "latitude: " + intersect.object.userData.lat
                popup.innerHTML += "<br/> longitude:" + intersect.object.userData.long
                popup.innerHTML += "<br/> Pays: " + intersect.object.userData.name
            } else {
                popup.innerHTML = "latitude: " + intersect.object.userData.lat
                popup.innerHTML += "<br/> longitude:" + intersect.object.userData.long
                popup.innerHTML += "<br/> magnitude: " + intersect.object.userData.magnitude
            }
            // popup.innerHTML = "C'est un séisme de magnitude " + intersect.object.userData.magnitude

            // Ferme le pop-up lorsqu'on clique dessus
            popup.onclick = function() {
                popup.style.display = "none";
            };

            // actions avec l'objet sélectionné
            break;
        }

    }
}

function init() {

    // Earth params
    var radius = 0.5,
        segments = 32,
        rotation = 6;

    var clock = new THREE.Clock();
    var scene = new THREE.Scene();

    var camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 2;

    var raycaster = new THREE.Raycaster();
    var mouse = new THREE.Vector2();

    var renderer = new THREE.WebGLRenderer();

    renderer.setClearColor(new THREE.Color(0xEEEEEE, 1.0));
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.shadowMapEnabled = true;
    scene.add(new THREE.AmbientLight(0x333333));

    var light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(5, 3, 5);
    scene.add(light);

    var sphere = createSphere(radius, segments);
    sphere.rotation.y = rotation;
    scene.add(sphere)

    var clouds = createClouds(radius, segments);
    clouds.rotation.y = rotation;
    scene.add(clouds)

    var stars = createStars(90, 64);
    scene.add(stars);
    // // Example positions
    // var positions = [
    //     { lat: 48.8566, lon: 2.3522 }, // Paris
    //     { lat: 40.7128, lon: -74.0060 }, // New York
    //     { lat: 35.6895, lon: 139.6917 }, // Tokyo
    //     { lat: 51.5074, lon: -0.1278 }, // London
    //     { lat: -23.5505, lon: -46.6333 } // São Paulo
    // ];
    // lib D3 
   /* d3.csv("countries.csv").then(function(data) {
        data.forEach(function(d) {
            // Utilisez les valeurs de chaque objet pour créer votre point sur la sphère
            let lat = parseFloat(d.latitude);
            let long = parseFloat(d.longitude);
            let name = d.name;

            // Convertir les coordonnées de latitude et longitude en coordonnées 3D
            let position = calcPosFromLatLonRad(lat, long, radius);

            // Créer l'objet sélectionnable et l'ajouter à la sphère
            let point = createSelectableObject(0xff0000, position); // Utilisez la couleur rouge (0xff0000) pour les objets sélectionnables
            point.userData.lat = lat; // Ajoute le nom de la ville aux données utilisateur de l'objet
            point.userData.long = long; // Ajoute le nom de la ville aux données utilisateur de l'objet
            point.userData.name = name; // Ajoute le nom de la ville aux données utilisateur de l'objet
            sphere.add(point);
        });
    });*/

    d3.csv("earthquakes.csv", function(data) {
        console.log(data);
    });

    d3.csv("earthquakes.csv").then(function(data) {

        data.forEach(function(d) {
            let lat = parseFloat(d.location_latitude);
            let long = parseFloat(d.location_longitude);
            let magnitude = d.impact_magnitude;

            let position = calcPosFromLatLonRad(lat, long, radius);

            // Remplacez cette ligne :
            // let point = createSelectableObject(0xff00ff, position);
            // Par celle-ci :
            let point = createTriangle(0xff00ff, position);

            point.userData.magnitude = magnitude;
            point.userData.lat = lat;
            point.userData.long = long;
            sphere.add(point);
        });
    });

    var ambientLight = new THREE.AmbientLight(0x0c0c0c);
    scene.add(ambientLight);

    document.getElementById("WebGL-output").appendChild(renderer.domElement);

    var controls = new THREE.TrackballControls(camera);

    /*var moonDistance = 1.5; // La distance de la Lune par rapport à la Terre (en unités arbitraires)
    var moon = createMoon(radius * 0.273, segments);
    moon.position.set(moonDistance, 0, 0);
    scene.add(moon);*/

    renderScene();


    function renderScene() {
        controls.update();

        // Calculer la rotation et la position de la Lune autour de la Terre
        var delta = clock.getDelta();
        var earthRotationSpeed = 0.05; // La vitesse de rotation de la Terre

        // Décommentez les lignes ci-dessous pour activer la rotation de la Terre et des nuages
        sphere.rotation.y += earthRotationSpeed * delta;
        clouds.rotation.y += earthRotationSpeed * delta;

        // Mettre à jour la position de la Lune
       // updateMoonPosition();

        requestAnimationFrame(renderScene);
        renderer.render(scene, camera);
    }

    document.addEventListener("click", onMouseClick, false);
    clock.start();
}

document.addEventListener("DOMContentLoaded", function() {
    init();
});