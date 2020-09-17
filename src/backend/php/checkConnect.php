<?php
// imports
require_once("./database.php");

// sets output buffering = prevents output until ob_flush
ob_start();

$connexionPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/TP/TP6-CTS/dist/connexion.html";
// redirection
header("refresh:5; url=$connexionPage");

$requestBody = file_get_contents('php://input');


if ($requestBody) {
    $requestBody = json_decode($requestBody);
    
    $DB = new Database("admin", "E.F.Codd", "cts", false);
    $admins = $DB->FetchAll("Admin");
    
    // check if there is a match
    $match = false;
    foreach ($admins as $admin) {
        // check user name / mail
        if ($admin["mailAdmin"] != $requestBody->mail) {
            continue;
        }
        // same user name -> check password
        // check match
        $pwd = $requestBody->motDePasse;
        if (password_verify($pwd, $admin["mdpAdmin"])) {
            $match = true;
            break;
        }
    }
    
    
    if ($match) {
        echo "Connexion réussie ! 😀<br/>";
        http_response_code(200); // OK
    } else {
        http_response_code(401); // Unauthorized
    }
} else {
    http_response_code(400); // Bad Request
}

// allows output
ob_flush();
// TODO this is to be in Admin class
