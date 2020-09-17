<?php
require_once __DIR__ . "/../controller/ContactController.php";

class Contact
{
	private int $code;
	private string $nom;
	private string $prenom;
	private DateTime $dateNaissance;
	private int $codePays;

	private ContactController $controller;

	/**
	 * Initailize a new Contact object.
	 * @todo
	 */
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

	/**
	 * Get the Contact controller instance.
	 */
	public function getController(): ContactController
	{
		return $this->controller;
	}

	/**
	 * Get the value of code.
	 */
	public function getCode(): int
	{
		return $this->code;
	}

	/**
	 * Set the value of code.
	 */
	public function setCode($code): void
	{
		$this->code = $code;
	}

	/**
	 * Get the value of nom.
	 */ 
	public function getNom()
	{
		return $this->nom;
	}

	/**
	 * Set the value of nom.
	 */ 
	public function setNom($nom)
	{
		$this->nom = $nom;

		return $this;
	}

	/**
	 * Get the value of prenom.
	 */ 
	public function getPrenom()
	{
		return $this->prenom;
	}

	/**
	 * Set the value of prenom.
	 */ 
	public function setPrenom($prenom)
	{
		$this->prenom = $prenom;
	}

	/**
	 * Get the value of dateNaissance.
	 */ 
	public function getDateNaissance()
	{
		return $this->dateNaissance;
	}

	/**
	 * Set the value of dateNaissance.
	 */ 
	public function setDateNaissance($dateNaissance)
	{
		$this->dateNaissance = $dateNaissance;
	}

	/**
	 * Get the value of codePays.
	 */ 
	public function getCodePays()
	{
		return $this->codePays;
	}

	/**
	 * Set the value of codePays.
	 */ 
	public function setCodePays($codePays)
	{
		$this->codePays = $codePays;
	}
}
