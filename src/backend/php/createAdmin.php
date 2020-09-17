<?php
require_once("./database.php");

// link with database
$DB = new Database("admin", "E.F.Codd", "cts", false);

// prepare the hash
$salt = random_bytes(64);
$hashed = crypt($pwd, $salt);


$success = $DB->createAdmin($name, $firstname, $mail, $hashed, $salt);

if ($success) {
    echo "Ajout d'admin réussi ! 😀<br/>";
} else {
    echo "Ajout d'admin échoué ! ☹<br/>";
}
