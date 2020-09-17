<?php
require_once("./database.php");

$connexionPage = isset($_SERVER['HTTP_REFERER']) ? isset($_SERVER['HTTP_REFERER']) : "/TP/TP6-CTS/dist/connexion.html";

if (isset($_POST["mail"]) && isset($_POST["pwd"])) {
    $DB = new Database("admin", "E.F.Codd", "cts", false);
    $admins = $DB->FetchAll("Admin");
    
    // check if there is a match
    $match = false;
    foreach ($admins as $admin) {
        // check user name / mail
        if ($admin["mailAdmin"] != $_POST["mail"]) {
            continue;
        }
        // same user name -> check password
        // check match
        if (password_verify($pwd, $admin["mdpAdmin"])) {
            $match = true;
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
