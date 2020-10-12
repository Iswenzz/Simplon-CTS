<?php
require_once __DIR__ . "/Response.php";

interface CRUD
{
	function update(): Response;
	function delete(): Response;
	function get(): Response;
	function getAll(): Response;
	function add(): Response;
}
