<?php
require "../controller/ContactController.php";

class Contact
{
	private int $code;
	private string $nom;
	private string $prenom;
	private DateTime $dateNaissance;
	private int $codePays;

	private ContactController $controller;

	public function __construct(int $code, string $nom, string $prenom, 
		DateTime $dateNaissance, int $codePays)
	{
		$this->code = $code;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->dateNaissance = $dateNaissance;
		$this->codePays = $codePays;
		$this->controller = new ContactController($this, new ContactView($this));
	}

	public function getController(): ContactController
	{
		return $this->controller;
	}

	public function getCode(): int
	{
		return $this->code;
	}

	public function setCode($code): void
	{
		$this->code = $code;
	}
}
