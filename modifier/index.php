<?php 

$event_name = filter_input(INPUT_POST, "event_name");
$event_date = filter_input(INPUT_POST, "event_date");

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

$requete = $pdo->prepare("SELECT nom FROM `evenements`");
// Etape 2 : j'exécute la requête
$requete->execute();
$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <title>Modifier</title>
</head>
<body>
<a href="../index.php"><button>Retour</button></a>
<form>
      <label for="event_name">Nom de l'événement :</label>
      <select name="event_name" id="event_name" name="event_name" required>
            <?php 
                foreach($resultats as $resultat) {
                    echo '<option value="' . $resultat['nom'] . '">' . $resultat['nom'] . '</option>';
                }
            ?>
      </select>

      <label for="event_date">Date de l'événement :</label>
      <input type="date" id="event_date" name="event_date" value="2023-06-15" required>
      
      <input type="submit" value="Modifier l'événement">
    </form>
</body>
</html>