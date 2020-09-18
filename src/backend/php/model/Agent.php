<?php
require_once __DIR__ . "/../controller/AgentController.php";

class Agent
{
	private int $code;
	private string $nom;
	private string $prenom;
	private DateTime $dateNaissance;
	private int $codePays;

	private AgentController $controller;

	/**
	 * Initailize a new Agent object.
	 */
	public function __construct(int $code, string $nom, string $prenom, 
		DateTime $dateNaissance, int $codePays)
	{
		$this->code = $code;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->dateNaissance = $dateNaissance;
		$this->codePays = $codePays;
		$this->controller = new AgentController($this, new AgentView($this));
	}

	/**
	 * Get the Agent controller instance.
	 */
	public function getController(): AgentController
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
	public function setCode(int $code): void
	{
		$this->code = $code;
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
	public function getDateNaissance(): DateTime
	{
		return $this->dateNaissance;
	}

	/**
	 * Set the value of dateNaissance.
	 */ 
	public function setDateNaissance(DateTime $dateNaissance): void
	{
		$this->dateNaissance = $dateNaissance;
	}

	/**
	 * Get the value of codePays
	 */ 
	public function getCodePays(): int
	{
		return $this->codePays;
	}

	/**
	 * Set the value of codePays
	 */ 
	public function setCodePays(int $codePays): void
	{
		$this->codePays = $codePays;
	}
}
