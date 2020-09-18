<?php
require_once __DIR__."/Response.php";

class ConnectionResponse extends Response
{
    private string $key;
    private string $user;

    public function __construct(bool $success = false, int $httpCode = 500, string $message = "Connexion non exécutée", string $key = "", string $user = "")
    {
        parent::__construct($success, $httpCode, $message);
        $this->key = $key;
        $this->user = $user;
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
    public function getUser() : string
    {
        return $this->user;
    }
    public function setUser(string $user)
    {
        $this->user = $user;
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
        http_response_code($this->getHttpCode());
        $return = json_encode(
            [
                "success" => $this->getSuccess(),
                "message" => $this->getMessage(),
                "key" => urlencode($this->getKey()),
                "user" => urlencode($this->getUser())
            ]
        );
        echo $return;
    }
}
