<?php
require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/Pays.php";

class Contact extends Model implements JsonSerializable
{
	private ?int $code;
	private string $nom;
	private string $prenom;
	private DateTime $dateNaissance;
	private ?Pays $pays;

	/**
	 * Initialize a new Contact object.
	 * @param int|null $code - The contact code.
	 * @param string $nom - The contact name.
	 * @param string $prenom - The contact firstname.
	 * @param DateTime|null $dateNaissance - The contact birthdate.
	 * @param Pays|null $pays
	 */
	public function __construct(
		?int $code = null,
		string $nom = "",
		string $prenom = "",
		DateTime $dateNaissance = null,
		Pays $pays = null)
	{
		$this->code = $code;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->dateNaissance = $dateNaissance ?? new DateTime();
		$this->pays = $pays;
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
	 * @param int|null $code
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
	 * @param string $nom
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
	 * @param string $prenom
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
	 * @param DateTime $dateNaissance
	 */
	public function setDateNaissance(DateTime $dateNaissance): void
	{
		$this->dateNaissance = $dateNaissance;
	}

	/**
	 * @return Pays|null
	 */
	public function getPays(): ?Pays
	{
		return $this->pays;
	}

	/**
	 * @param Pays|null $pays
	 */
	public function setPays(?Pays $pays): void
	{
		$this->pays = $pays;
	}

	/**
	 * Serialize the object.
	 */
	public function jsonSerialize(): array
	{
		return [
			"code" => $this->getCode(),
			"nom" => $this->getNom(),
			"prenom" => $this->getPrenom(),
			"dateNaissance" => $this->getDateNaissance()->format("Y-m-d"),
			"pays" => $this->getPays() ? $this->getPays()->jsonSerialize() : null
		];
	}
}
