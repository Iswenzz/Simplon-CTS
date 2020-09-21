<?php
// imports
require_once("./database.php");
require_once __DIR__."/ConnectionResponse.php";

// sets output buffering = prevents output until ob_flush
ob_start();

// $connexionPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/TP/TP6-CTS/dist/connexion.html";
// // redirection
// header("refresh:5; url=$connexionPage");

$requestBody = file_get_contents('php://input');

// response
$response = new ConnectionResponse();


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
    
    // getting the corresponding key
    if ($match) {
        $response->setHttpCode(Response::OK);
        $response->setMessage("Identifiants valides :)");
        $response->setSuccess(true);
        
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
            $response->setMessage("Nouvelle clé générée");
            $key = random_bytes(31);
            $response->setSuccess($DB->updateApiKey($admin["mailAdmin"], $key));
            // DB error during generation
            if (!$response->getSuccess()) {
                $response->setHttpCode(Response::INTERNAL_SERVER_ERROR);
                $response->setMessage("Erreur lors de la génération de clé de connexion :(");
            } else {
                $response->setKey($key);
                $response->setUser($mail);
            }
        } else { // reading existing key
            $response->setMessage("Récupération de la clé");
            $response->setKey($admin["apiKey"]);
            $response->setUser($mail);
        }
    } else { // no mail/password match
        $response->setSuccess(false);
        $response->setHttpCode(Response::OK);
        $response->setMessage("Mauvais email et / ou mot de passe :(");
    }
} else { // empty request
    $response->setSuccess(false);
    $response->setHttpCode(Response::BAD_REQUEST);
    $response->setMessage("Mauvaise syntaxe de requête / paramètres manquants :(");
}

$response->send();

// allows output
ob_flush();
// TODO this is to be in Admin class
