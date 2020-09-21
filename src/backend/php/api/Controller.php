<?php
require_once __DIR__ . "/Response.php";

abstract class Controller 
{
	public DAO $dao;
	public Response $response;

	public abstract function respond(): void;
}
