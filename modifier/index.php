<?php 

$event_name = filter_input(INPUT_POST, "event_name");
$event_date = filter_input(INPUT_POST, "event_date");
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

        $modif = $pdo->prepare("UPDATE `evenements` SET `date`=:event_date WHERE `nom`=:event_name;");
        // Etape 2 : j'exécute la requête
        $modif->execute(
        [
            ":event_name" => $event_name,
            ":event_date" => $event_date
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <style>
            /* styles pour le formulaire */
            form {
            width: 500px; /* largeur du formulaire */
            margin: 50px auto; /* centrage horizontal et marge en haut */
            border: 1px solid #ccc; /* bordure grise */
            padding: 20px; /* espace intérieur */
            border-radius: 10px; /* coins arrondis */
        }
        
        /* styles pour les champs du formulaire */
        label {
            display: block; /* affichage en bloc */
            margin-bottom: 10px; /* marge en bas */
            font-weight: bold; /* texte en gras */
        }
        
        input[type=text], select {
            width: 100%; /* largeur du champ */
            padding: 10px; /* espace intérieur */
            border: 1px solid #ccc; /* bordure grise */
            border-radius: 5px; /* coins arrondis */
            margin-bottom: 20px; /* marge en bas */
        }
        
        /* styles pour le bouton de soumission */
        input[type=submit] {
            background-color: #4CAF50; /* couleur de fond */
            color: white; /* couleur du texte */
            border: none; /* pas de bordure */
            padding: 10px 20px; /* espace intérieur */
            text-align: center; /* alignement du texte */
            text-decoration: none; /* pas de soulignement */
            display: inline-block; /* affichage en ligne */
            font-size: 16px; /* taille de police */
            border-radius: 5px; /* coins arrondis */
            cursor: pointer; /* curseur pointeur au survol */
            margin-left: 150px;
        }

        button {
            background-color: #4CAF50; /* couleur de fond */
            color: white; /* couleur du texte */
            border: none; /* pas de bordure */
            padding: 10px 20px; /* espace intérieur */
            text-align: center; /* alignement du texte */
            text-decoration: none; /* pas de soulignement */
            display: inline-block; /* affichage en ligne */
            font-size: 16px; /* taille de police */
            border-radius: 5px; /* coins arrondis */
            cursor: pointer; /* curseur pointeur au survol */

        }
    </style>
    <title>Modifier</title>
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

      <label for="event_date">Date de l'événement :</label>
      <input type="date" id="event_date" name="event_date" required>
      
      <input id="submit"type="submit" value="Modifier l'événement">
    </form>
</body>
</html>