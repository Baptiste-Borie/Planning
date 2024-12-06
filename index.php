<head>
    <meta charset="utf-8">
    <title>Planning</title>
    <meta name="viewport" content="width=device-width">
    <!-- Font -->
    <link href="View/style/general.css" rel="stylesheet" type="text/css">
    <link href="View/style/header-footer.css" rel="stylesheet" type="text/css">
    <link href="View/style/mainSection.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|Nunito|Glegoo" rel="stylesheet">
    <!-- Fontawesome -->
    <script src="./View/js/fontawesome-all.min.js"></script>
    <!-- Icon -->
    <link href="./View/img/icon.png" rel="icon">
</head>

<?php
$USERS_COLLECTION = "Planning.users";

session_start();
require_once('./Model/Connection.php');
$connection = new Connection();
$manager = $connection->getManager();

// Requête pour récupérer les documents d'une collection
$query = new MongoDB\Driver\Query([]); // Filtre vide pour récupérer tout
$cursor = $manager->executeQuery($USERS_COLLECTION, $query);

// Gestion des contrôleurs et des actions
if (
    (isset($_GET['ctrl']) && !empty($_GET['ctrl'])) &&
    (isset($_GET['action']) && !empty($_GET['action']))
) {
    $ctrl = $_GET['ctrl'];
    $action = $_GET['action'];
} else {
    // Pas de contrôleur/action précisé -> charger la page par défaut
    $ctrl = 'user';
    $action = 'home';
}

require_once('./Controller/' . $ctrl . 'Controller.php');
$ctrl = $ctrl . 'Controller';
$controller = new $ctrl($manager);
$controller->$action();
