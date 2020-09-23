<?php
require_once __DIR__ . "/../controller/ContactController.php";

class Contact implements JsonSerializable
{
	private ?int $code;
	private string $nom;
	private string $prenom;
	private DateTime $dateNaissance;
	private int $codePays;

	private ContactController $controller;

	/**
	 * Initailize a new Contact object.
	 * @param int|null $code - The contact code.
	 * @param string $nom - The contact name.
	 * @param string $prenom - The contact firstname.
	 * @param DateTime|null $dateNaissance - The contact birthdate.
	 * @param int $codePays - The contact country code.
	 */
	public function __construct(?int $code = null, string $nom = "",
		string $prenom = "", DateTime $dateNaissance = null, int $codePays = 0)
	{
		$this->code = $code;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->dateNaissance = $dateNaissance ?? new DateTime();
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
	public function getCode(): ?int
	{
		return $this->code;
	}

	/**
	 * Set the value of code.
	 */
	public function setCode(?int $code): void
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

	/**
	 * Serialize the model data for JSON encoding.
	 */
	public function jsonSerialize(): array
	{
		return [
			"code" => $this->getCode(),
			"nom" => $this->getNom(),
			"prenom" => $this->getPrenom(),
			"dateNaissance" => $this->getDateNaissance()->format("Y-m-d"),
			"codePays" => $this->getCodePays()
		];
	}
}
