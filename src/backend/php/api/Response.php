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
	private $data;

	/**
	 * Initialize a new Response object.
	 * @param int $httpCode - The response code.
	 * @param bool $success - The success state.
	 * @param string $message - The response message.
	 */
	public function __construct(bool $success = false, 
		int $httpCode = Response::NOT_IMPLEMENTED, string $message = "Message par défaut")
	{
		$this->success = $success;
		$this->httpCode = $httpCode;
		$this->message = $message;
	}

	/**
	 * Prepare an HTTP response with the specified parameter.
	 * @param int $httpCode - The response code.
	 * @param bool $success - The success state.
	 * @param string $message - The response message.
	 * @param mixed $data - The response data.
	 * @param bool $debug - Print debug informations.
	 */
	public function prepare(int $httpCode, bool $success, 
		string $message, $data = null, bool $debug = false): Response
	{
		$this->setHttpCode($httpCode);
		$this->setSuccess($success);
		$this->setMessage($message, $debug);
		$this->setData($data);
		return $this;
	}
	
	/**
	 * Sends the prepared response to the output as JSON,
	 * with the HTTP code sent in an HTTP header.
	 */
	public function send(): void
	{
		header('Content-Type: application/json');
		http_response_code($this->httpCode);
		$return = json_encode(
			[
				"message" => $this->message,
				"success" => $this->success,
				"body" => $this->data
			]
		);
		echo $return;
	}

	/**
	 * Get the value of success
	 */ 
	public function getSuccess(): bool
	{
		return $this->success;
	}

	/**
	 * Set the value of success
	 */ 
	public function setSuccess(bool $success): void
	{
		$this->success = $success;
	}

	/**
	 * Get the value of httpCode
	 */ 
	public function getHttpCode(): int
	{
		return $this->httpCode;
	}

	/**
	 * Set the value of httpCode
	 */ 
	public function setHttpCode(int $httpCode): void
	{
		$this->httpCode = $httpCode;
	}

	/**
	 * Get the value of message
	 */ 
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * Set the value of message
	 * @param bool $debug - Print debug informations
	 */ 
	public function setMessage(string $message, bool $debug = false): void
	{
		$this->message = $message;
		if ($debug)
			print_r($this->message);
	}

	/**
	 * Get the value of data
	 */ 
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Set the value of data
	 */ 
	public function setData($data): void
	{
		$this->data = $data;
	}
}
