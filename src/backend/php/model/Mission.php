<?php
require_once __DIR__ . "/../controller/MissionController.php";

class Mission implements JsonSerializable
{
	private ?int $code;
	private string $titre;
	private string $description;
	private DateTime $dateDebut;
	private DateTime $dateFin;
	private int $codeStatut;
	private int $codeType;
	private int $codeSpecialite;

	private MissionController $controller;

	/**
	 * Initialize a new Mission object.
	 * @param int|null $code - The mission primary key.
	 * @param string $titre - The mission title.
	 * @param string $description - The mission description.
	 * @param DateTime|null $dateDebut - The mission start date.
	 * @param DateTime|null $dateFin - The mission end date.
	 * @param int $codeStatut - The mission statut code.
	 * @param int $codeType - The mission type code.
	 * @param int $codeSpecialite - The mission speciality code.
	 */
	public function __construct(?int $code = 0, string $titre = "", string $description = "",
		DateTime $dateDebut = null, DateTime $dateFin = null, int $codeStatut = 0,
		int $codeType = 0, int $codeSpecialite = 0)
	{
		$this->code = $code;
		$this->titre = $titre;
		$this->description = $description;
		$this->dateDebut = $dateDebut ?? new DateTime();
		$this->dateFin = $dateFin ?? new DateTime();
		$this->codeStatut = $codeStatut;
		$this->codeType = $codeType;
		$this->codeSpecialite = $codeSpecialite;
		$this->controller = new MissionController($this, new MissionView($this));
	}

	/**
	 * Get the Mission controller instance.
	 */
	public function getController(): MissionController
	{
		return $this->controller;
	}

	/**
	 * Get the value of code
	 */ 
	public function getCode(): ?int
	{
		return $this->code;
	}

	/**
	 * Set the value of code
	 */ 
	public function setCode(?int $code): void
	{
		$this->code = $code;
	}

	/**
	 * Get the value of titre
	 */ 
	public function getTitre(): string
	{
		return $this->titre;
	}

	/**
	 * Set the value of titre
	 */ 
	public function setTitre(string $titre): void
	{
		$this->titre = $titre;
	}

	/**
	 * Get the value of description
	 */ 
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * Set the value of description
	 */ 
	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	/**
	 * Get the value of dateDebut
	 */ 
	public function getDateDebut(): DateTime
	{
		return $this->dateDebut;
	}

	/**
	 * Set the value of dateDebut
	 */ 
	public function setDateDebut(DateTime $dateDebut): void
	{
		$this->dateDebut = $dateDebut;
	}

	/**
	 * Get the value of dateFin
	 */ 
	public function getDateFin(): DateTime
	{
		return $this->dateFin;
	}

	/**
	 * Set the value of dateFin
	 */ 
	public function setDateFin(DateTime $dateFin): void
	{
		$this->dateFin = $dateFin;
	}

	/**
	 * Get the value of codeStatut
	 */ 
	public function getCodeStatut(): int
	{
		return $this->codeStatut;
	}

	/**
	 * Set the value of codeStatut
	 */ 
	public function setCodeStatut(int $codeStatut): void
	{
		$this->codeStatut = $codeStatut;
	}

	/**
	 * Get the value of codeType
	 */ 
	public function getCodeType(): int
	{
		return $this->codeType;
	}

	/**
	 * Set the value of codeType
	 */ 
	public function setCodeType(int $codeType): void
	{
		$this->codeType = $codeType;
	}

	/**
	 * Get the value of codeSpecialite
	 */ 
	public function getCodeSpecialite(): int
	{
		return $this->codeSpecialite;
	}

	/**
	 * Set the value of codeSpecialite
	 */ 
	public function setCodeSpecialite(int $codeSpecialite): void
	{
		$this->codeSpecialite = $codeSpecialite;
	}

	/**
	 * Serialize the object.
	 */
	public function jsonSerialize()
	{
		return [
			"code" => $this->getCode(),
			"titre" => $this->getTitre(),
			"description" => $this->getDescription(),
			"dateDebut" => $this->getDateDebut()->format("Y-m-d"),
			"dateFin" => $this->getDateFin()->format("Y-m-d"),
			"codeStatut" => $this->getCodeStatut(),
			"codeType" => $this->getCodeType(),
			"codeSpecialite" => $this->getCodeSpecialite(),
		];
	}
}
