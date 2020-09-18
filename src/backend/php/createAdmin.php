<?php
// imports
require_once("./database.php");
require_once("./Response.php");

// sets output buffering = prevents output until ob_flush
ob_start();


$requestBody = file_get_contents('php://input');

// response
$response = new Response();


if ($requestBody) {
    $requestBody = json_decode($requestBody);
    
    // TODO : Julie's DB ids
    $DB = new Database("admin", "E.F.Codd", "cts", false);
    $admins = $DB->FetchAll("Admin");
    
    // check if there is a match
    $match = false;
    foreach ($admins as $admin) {
        // check user name / mail
        if ($admin["mailAdmin"] == $requestBody->mail) {
            $match = true;
            break;
        }
    }

    // there is already an admin with this email
    if ($match) {
        $response->setSuccess(false);
        $response->setHttpCode(Response::BAD_REQUEST);
        $response->setMessage("Il existe déjà un administrateur possédant cet email !");
    } else {
        // hash the password
        $hashed = password_hash($requestBody->password, PASSWORD_DEFAULT);
        // register a new admin
        $response->setSuccess($DB->createAdmin($requestBody->name, $requestBody->firstName, $requestBody->mail, $hashed));

        // error while registering
        if (!$response->getSuccess()) {
            $response->setHttpCode(Response::INTERNAL_SERVER_ERROR);
            $response->setMessage("Erreur lors de l'enregistrement du nouvel admin :(");
        } else {
            $response->setHttpCode(Response::OK);
            $response->setMessage("Enregistrement exécuté avec succès :) Retour sur la page de connexion...");
            // redirection
            // $connexionPage = "./connexion.html";
            // header("refresh:5; url=$connexionPage");
        }
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
