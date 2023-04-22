<?php

$event_name = filter_input(INPUT_POST, "event_name");
$event_date = filter_input(INPUT_POST, "event_date");
$methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");

if (!empty($event_name)||!empty($event_date)) {
// Type de moteur de BDD : mysql
$moteur = "mysql";
// Hôte : localhost
$hote = "localhost";
// Port : 3306 (par défaut pour MySQL, avec MAMP macOS c'est 8889)
$port = 3306;
// Nom de la BDD (facultatif) : sakila
$nomBdd = "projet_back_end";
// Nom d'utilisateur : root
$nomUtilisateur = "root";
// Mot de passe : 
$motDePasse = "";

$pdo = new PDO(
    "$moteur:host=$hote:$port;dbname=$nomBdd", 
    $nomUtilisateur, 
    $motDePasse
);

$recup = $pdo->prepare("SELECT * FROM evenements WHERE nom = :event_name");
// Etape 2 : j'exécute la requête
$recup->execute(
[
  ":event_name" => $event_name,
]
);
$resultat = $recup->fetchAll(PDO::FETCH_ASSOC);

if ($methode == "POST") {

  if (!empty($event_name)||!empty($event_date)) {

    if ($recup->rowCount() == 0) {

      $requete = $pdo->prepare("INSERT INTO `evenements`(`nom`, `date`) VALUES (:event_name,:event_date)");
      $requete->execute(
      [
          ":event_name" => $event_name,
          ":event_date" => $event_date
      ]);

      header('Location: ./confirm_page/index.php');
      exit(); // Coupe PHP

    } else {
      header('Location: ./denied_page/index.php');
      exit(); // Coupe PHP
  }
}
}
}
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <title>Creer</title>
</head>
  <body>
  <a href="../index.php"><button>Retour</button></a>
    <form method="POST">
        
      <label for="event_name">Nom de l'événement :</label>
      <input type="text" id="event_name" name="event_name" placeholder="Entrez le nom de l'événement" required>
      
      <label for="event_date">Date de l'événement :</label>
      <input type="date" id="event_date" name="event_date" required>

      <input type="submit" value="Créer l'événement">
    </form>
    
  </body>
</html>
