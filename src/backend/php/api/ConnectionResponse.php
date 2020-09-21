<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/../model/Admin.php";

class ConnectionResponse extends Response
{
    public function __construct(
        bool $success = false,
        int $httpCode = 500,
        string $message = "Connexion non exécutée"
    )
    {
        parent::__construct($success, $httpCode, $message);
    }
    
    /**
     * Sends the prepared response to the output as JSON,
     * with the HTTP code sent in an HTTP header.
     *
     * @param Admin $admin
     * @return void
     */
    public function send($admin)
    {
        header('Content-Type: application/json');
        http_response_code($this->getHttpCode());
        $apiKey = $admin ? $admin->getApiKey() : "";
        $email = $admin ? $admin->getEmail() : "";
        $return = json_encode(
            [
                "success" => $this->getSuccess(),
                "message" => $this->getMessage(),
                "key" => urlencode($apiKey),
                "user" => urlencode($email)
            ]
        );
        echo $return;
    }
}
