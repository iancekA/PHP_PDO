<form  action="index_PHP_PDO.php"  method="post">
    <div>
        <label  for="nom">Nom :</label>
        <input  type="text"  id="nom"  name="lastname">
        </div>
        <div>
        <label  for="prénom">Prénom :</label>
        <input  type="text"  id="prénom"  name="firstname">
        </div>
        <div  class="button">
        <input  type="submit" name="submit">Envoyer votre message</input>
    </div>
</form>

<?php

// ----------------------------------CONNEXION-------------------------

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

// ----------------------------------RECHERCHE-------------------------

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_BOTH); 

echo nl2br("------------------------------------------------AVANT INSERTION------------------------------------------------------------\n");

foreach($friends as $friend) {
    echo $friend['firstname'] . ' ' . $friend['lastname'];
    echo nl2br("\n");
}

if (!empty($_POST['submit'])){

// ----------------------------------INSERTION---------------------------------------

	$firstname = trim(htmlspecialchars($_POST['firstname']));  
	$lastname = trim(htmlspecialchars($_POST['lastname']));


    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

    $statement->execute();

// ----------------------------------RECHERCHE-------------------------

    $query = "SELECT * FROM friend";
    $statement = $pdo->query($query);
    $friends = $statement->fetchAll(PDO::FETCH_BOTH); 

    echo nl2br("------------------------------------------------APRES INSERTION------------------------------------------------------------\n");

    foreach($friends as $friend) {
        echo $friend['firstname'] . ' ' . $friend['lastname'];
        echo nl2br("\n");
    }
}