<?php
require_once("./database.php");

$connexionPage = $_SERVER['HTTP_REFERER'];

if (isset($_POST["mail"]) && isset($_POST["pwd"])) {
    $DB = new Database("admin", "E.F.Codd", "cts", false);
    $admins = $DB->FetchAll("Admin");
    
    // check if there is a match
    $match = false;
    foreach ($admins as $value) {
        $match = $value["mdpAdmin"] == $_POST["pwd"] &&
            $value["mailAdmin"] == $_POST["mail"];
        
        if ($match) {
            break;
        }
    }
    
    if ($match) {
        echo "Connexion réussie ! 😀<br/>";
    } else {
        header("refresh:3; url=$connexionPage");
        echo "Connexion échouée ! ☹<br/> Retour  dans 3 secondes...";
    }
} else {
    echo "Pseudo ou mdp manquant !";
}
