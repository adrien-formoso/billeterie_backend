<?php 

$event_name = filter_input(INPUT_POST, "event_name");

$methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");

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

if ($methode == "POST") {

    if (!empty($event_name)||!empty($event_date)) {

      $modif = $pdo->prepare("DELETE FROM `evenements` WHERE `nom`=:event_name;");
      // Etape 2 : j'exécute la requête
      $modif->execute(
      [
          ":event_name" => $event_name,

      ]
      );
      header('Location: ./confirm_page/index.php');
        exit(); // Coupe PHP
    } else {
        echo "merci de renseigner les valeurs";
    }
}

$recup = $pdo->prepare("SELECT nom FROM `evenements`");
// Etape 2 : j'exécute la requête
$recup->execute();
$resultats_recup = $recup->fetchAll(PDO::FETCH_ASSOC);

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
      <select name="event_name" id="event_name" name="event_name" required>
            <?php 
                foreach($resultats_recup as $resultats) {
                    echo '<option value="' . $resultats['nom'] . '">' . $resultats['nom'] . '</option>';
                    // echo $resultats;
                }
            ?>
      </select>

      <input type="submit" value="Supprimer l'event">
    </form>
    
  </body>
</html>
