<?php
require_once __DIR__ . "/../controller/AdministrateurController.php";

class Administrateur
{
	private string $email;
	private string $nom;
	private string $prenom;
	private DateTime $dateCreation;
	private string $mdp;

	private AdministrateurController $controller;

	/**
	 * Initailize a new Administrateur object.
	 */
	public function __construct(string $email, string $nom, string $prenom, 
		DateTime $dateCreation, string $mdp)
	{

		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->dateCreation = $dateCreation;
		$this->mdp = $mdp;
		$this->email = $email;
		$this->controller = new AdministrateurController($this, new AdministrateurView($this));
	}

	/**
	 * Get the Administrateur controller instance.
	 */
	public function getController(): AdministrateurController
	{
		return $this->controller;
	}

	/**
	 * Get the value of nom.
	 */ 
	public function getNom(): string
	{
		return $this->nom;
	}

	/**
	 * Set the value of nom.
	 */ 
	public function setNom(string $nom): void
	{
		$this->nom = $nom;
	}

	/**
	 * Get the value of prenom.
	 */ 
	public function getPrenom(): string
	{
		return $this->prenom;
	}

	/**
	 * Set the value of prenom.
	 */ 
	public function setPrenom(string $prenom): void
	{
		$this->prenom = $prenom;
	}

	/**
	 * Get the value of dateNaissance.
	 */ 
	public function getDateCreation(): DateTime
	{
		return $this->dateCreation;
	}

	/**
	 * Set the value of dateNaissance.
	 */ 
	public function setDateCreation(DateTime $dateCreation): void
	{
		$this->dateCreation = $dateCreation;
	}

	/**
	 * Get the value of mdp
	 */ 
	public function getMdp(): string
	{
		return $this->mdp;
	}

	/**
	 * Set the value of mdp
	 */ 
	public function setMdp(string $mdp): void
	{
		$this->mdp = $mdp;
	}

	/**
	 * Get the value of email
	 */ 
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * Set the value of email
	 */ 
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}
}
