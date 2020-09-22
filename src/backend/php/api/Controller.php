<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/../dao/DAO.php";

abstract class Controller 
{
	public DAO $dao;
	public Response $res;

	/**
	 * Prepare the request response.
	 */
	public abstract function response(): Response;
}
