<?php
require_once __DIR__."./Response.php";

class ConnectionResponse extends Response
{
    private string $key;

    public function __construct(bool $success = false, int $httpCode = 500, string $message = "Connexion non exécutée", string $key = null)
    {
        parent::__construct($success, $httpCode, $message);
        $this->key = $key;
    }
    
    // GETTERS & SETTERS
    public function getKey() : string
    {
        return $this->key;
    }
    public function setKey(string $key)
    {
        $this->key = $key;
    }
    
    // METHODS
    /**
     * Sends the prepared response to the output as JSON,
     * with the HTTP code sent in an HTTP header.
     *
     * @return void
     */
    public function send()
    {
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
    }
}
