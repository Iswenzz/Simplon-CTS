<?php

class Response
{
    private bool $success;
    private int $httpCode;
    private string $message;

    public function __construct(bool $success = false, int $httpCode = 500, string $message = "Non exécuté")
    {
        $this->success = $success;
        $this->httpCode = $httpCode;
        $this->message = $message;
    }
    
    // GETTERS & SETTERS
    public function getSuccess() : bool
    {
        return $this->success;
    }
    public function getHttpCode() : int
    {
        return $this->httpCode;
    }
    public function getMessage() : string
    {
        return $this->message;
    }
    
    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }
    public function setHttpCode(int $httpCode)
    {
        $this->httpCode = $httpCode;
    }
    public function setMessage(string $message)
    {
        $this->message = $message;
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
                "success" => $success
            ]
        );
        echo $return;
    }
}
