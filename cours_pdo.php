<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
require_once '/home/richubuntu/Info.prog/Cours/PHP/Challenges_PHP/PDO/connec.php'; // Appelle une seule et unique fois le fichier connec.php afin de permettre le log
$pdo = new \PDO(DSN, USER, PASS); //Données de connexion récupérées depuis connec.php.                             
?>

<form action="" method="post">
    <div>
        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" name="firstname" required></input>
    </div>
    <br>
    <div>
        <label for="lastname">Nom</label>
        <input type="text" id="lastname" name="lastname" required autofocus></input>
    </div>
    <br>
    <button type="submit">Valider</button>
</form>

<?php
$firstname = trim($_POST['firstname']); //Récupère les données rentrées par l'utilisateur dans la case correspondante
$lastname = trim($_POST['lastname']);   //Et applique l'instruction "trim" afin de supprimer les éventuels espaces avant et après la saisie

$query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)"; // lance une requête d'insertion et l'affecte à la variable $query

$statement = $pdo->prepare($query); //Signale à PDO qu'il travaille avec une requête préparée afin de pouvoir utiliser les bindValues
$statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);   // Puis PDO::PARAM_STR: Permet de restreindre les données à une chaine string UNIQUEMENT et éviter des symboles dangereux pour nos requêtes
$statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR); // Reprend les VALUES de la requête et fait le lien avec les variables $firstname et $lastname

$statement->execute(); //Execute la requête préparé
$friends =$statement->fetchAll(); //Récupère les résultats suite à l'execution de la requête préparée

$query = 'SELECT * FROM friend'; //Lance la requête SELECT et affecte le résultat dans la variable "$query"
$statement = $pdo->query($query); //??????????????????????????????????????????????????????????????????????????????
$friends = $statement->fetchAll(); // Récupère l'ensemble des résultat repris dans la variable $statement (fetch all) et l'affecte à la variable $friends.

//boucle foreach permettant de récupérer et afficher les données du tableau de la variable $friends
foreach ($friends as $arrayFriend) {
    echo "<br>";
    echo $arrayFriend['firstname'] . ' ' . $arrayFriend['lastname'];
}
?>

</body>
</html>