<?php

class Response
{
	public const OK = 200;
	public const BAD_REQUEST = 400;
	public const INTERNAL_SERVER_ERROR = 500;
	public const NOT_IMPLEMENTED = 501;

	private bool $success;
	private int $httpCode;
	private string $message;

	public function __construct(bool $success = false, 
		int $httpCode = Response::NOT_IMPLEMENTED, string $message = "Message par défaut")
	{
		$this->success = $success;
		$this->httpCode = $httpCode;
		$this->message = $message;
	}

	public function getSuccess(): bool
	{
		return $this->success;
	}
	
	public function getHttpCode(): int
	{
		return $this->httpCode;
	}

	public function getMessage(): string
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
	
	/**
	 * Sends the prepared response to the output as JSON,
	 * with the HTTP code sent in an HTTP header.
	 */
	public function send(array $data = null): void
	{
		header('Content-Type: application/json');
		http_response_code($this->httpCode);
		$return = json_encode(
			[
				"message" => $this->message,
				"success" => $this->success,
				"data" => json_encode($data)
			]
		);
		echo $return;
	}
}
