<?php
require_once("./database.php");

// link with database
$DB = new Database("admin", "E.F.Codd", "cts", true);
$errorMessage = "";

if (isset($_POST["nom"]) &&
isset($_POST["prenom"]) &&
isset($_POST["mail"]) &&
isset($_POST["motDePasse"])) {
    // reading the parameters
    list(
        "nom" => $name,
        "prenom" => $firstname,
        "mail" => $mail,
        "motDePasse" => $pwd
    ) = $_POST;

    // prepare the hash
    $hashed = password_hash($pwd, PASSWORD_DEFAULT);

    // adding to the database
    $success = $DB->createAdmin($name, $firstname, $mail, $hashed);
} else {
    $success = false;
    $errorMessage = "Il manque un paramètre";
}


if ($success) {
    echo "Ajout d'admin réussi ! 😀<br/>";
} else {
    echo "Ajout d'admin échoué ! ☹ $errorMessage<br/>";
}
