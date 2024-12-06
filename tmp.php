<?php

try {
    // Connexion à MongoDB Atlas
    $manager = new MongoDB\Driver\Manager('mongodb+srv://root:root@cluster0.aqghb.mongodb.net/');
    // Définition de la requête
    $filter = [];
    $option = [];
    $read = new MongoDB\Driver\Query($filter, $option);
    //Exécution de la requête
    $cursor = $manager->executeQuery('Planning.users', $read);
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Probleme! : " . $e->getMessage();
    exit();
}
// Affichage du résultat
echo '<table><caption>Listes des utilisateurs</caption><tr><th>Prénom</th><th>NO
M</th><th>Couleur</th></tr>';
foreach ($cursor as $user) {
    echo '<tr><td>' . $user->firstName . '</td><td>' . $user->lastName . '</td><td>' . $user->color . '</td><td></tr>';
}
echo '</table>';
