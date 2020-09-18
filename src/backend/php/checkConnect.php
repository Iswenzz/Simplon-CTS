<?php
// imports
require_once("./database.php");

// sets output buffering = prevents output until ob_flush
ob_start();

// $connexionPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/TP/TP6-CTS/dist/connexion.html";
// // redirection
// header("refresh:5; url=$connexionPage");

$requestBody = file_get_contents('php://input');

// response components
$message = "Connexion non exécutée";
$httpCode = 500; // Internal Server Error
$key = null;


if ($requestBody) {
    $requestBody = json_decode($requestBody);
    
    // TODO : Julie's DB ids
    $DB = new Database("admin", "E.F.Codd", "cts", false);
    $admins = $DB->FetchAll("Admin");
    
    // check if there is a match
    $match = false;
    foreach ($admins as $admin) {
        // check user name / mail
        if ($admin["mailAdmin"] != $requestBody->mail) {
            continue;
        }
        // same user name ✔
        $mail = $requestBody->mail;

        // check password match
        $pwd = $requestBody->motDePasse;
        if (password_verify($pwd, $admin["mdpAdmin"])) {
            $match = true;
            break;
        }
    }
    
    
    if ($match) {
        $httpCode = 200; // OK
        $message = "Identifiants valides :)";
        $success = true;
        
        // check if this admin already has a valid API key
        if (!is_null($admin["expirationApiKey"]) && !is_null($admin["apiKey"])) {
            $expirationDate = Datetime::createFromFormat("Y-m-d", $admin["expirationApiKey"]);
            $now = new Datetime();
            $valid = $now->diff($expirationDate)->format("%R") == "+"; // the diff is positive
        } else {
            $valid = false;
        }

        // no valid key -> generating a new one
        if (!$valid) {
            $message = "Nouvelle clé générée";
            $key = random_bytes(31);
            $success = $DB->updateApiKey($admin["mailAdmin"], $admin["mdpAdmin"], $key);
            // DB error during generation
            if (!$success) {
                $httpCode = 500; // Internal Server Error
                $message = "Erreur lors de la génération de clé de connexion :(";
            }
        } else { // reading existing key
            $message = "Récupération de la clé";
            $key = $admin["apiKey"];
        }
    } else { // no mail/password match
        $success = false;
        $httpCode = 400; // Bad Request
        $message = "Mauvais email et / ou mot de passe :(";
    }
} else { // empty request
    $success = false;
    $httpCode = 400; // Bad Request
    $message = "Mauvaise syntaxe de requête / paramètres manquants :(";
}

header('Content-Type: application/json');
http_response_code($httpCode);
$return = json_encode(
    [
        "message" => $message,
        "key" => urlencode($key),
        "success" => $success
    ]
);
echo $return;

// allows output
ob_flush();
// TODO this is to be in Admin class
