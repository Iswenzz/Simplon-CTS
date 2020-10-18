<?php
require_once __DIR__ . "/Model.php";

class Mission extends Model implements JsonSerializable
{
	private ?int $code;
	private string $titre;
	private string $description;
	private DateTime $dateDebut;
	private DateTime $dateFin;
	private ?Statut $statut;
	private ?TypeMission $typeMission;
	private ?Specialite $specialite;

	/**
	 * Initialize a new Mission object.
	 * @param int|null $code - The mission primary key.
	 * @param string $titre - The mission title.
	 * @param string $description - The mission description.
	 * @param DateTime|null $dateDebut - The mission start date.
	 * @param DateTime|null $dateFin - The mission end date.
	 * @param Statut|null $statut
	 * @param TypeMission|null $typeMission
	 * @param Specialite|null $specialite
	 */
	public function __construct(
		?int $code = 0,
		string $titre = "",
		string $description = "",
		DateTime $dateDebut = null,
		DateTime $dateFin = null,
		?Statut $statut = null,
		?TypeMission $typeMission = null,
		?Specialite $specialite = null)
	{
		$this->code = $code;
		$this->titre = $titre;
		$this->description = $description;
		$this->dateDebut = $dateDebut ?? new DateTime();
		$this->dateFin = $dateFin ?? new DateTime();
		$this->statut = $statut;
		$this->typeMission = $typeMission;
		$this->specialite = $specialite;
	}

	/**
	 * @return Statut|null
	 */
	public function getStatut(): ?Statut
	{
		return $this->statut;
	}

	/**
	 * @param Statut|null $statut
	 */
	public function setStatut(?Statut $statut): void
	{
		$this->statut = $statut;
	}

	/**
	 * @return TypeMission|null
	 */
	public function getTypeMission(): ?TypeMission
	{
		return $this->typeMission;
	}

	/**
	 * @param TypeMission|null $typeMission
	 */
	public function setTypeMission(?TypeMission $typeMission): void
	{
		$this->typeMission = $typeMission;
	}

	/**
	 * @return Specialite|null
	 */
	public function getSpecialite(): ?Specialite
	{
		return $this->specialite;
	}

	/**
	 * @param Specialite|null $specialite
	 */
	public function setSpecialite(?Specialite $specialite): void
	{
		$this->specialite = $specialite;
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
	 * @param int|null $code
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
	 * @param string $titre
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
	 * @param string $description
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
	 * @param DateTime $dateDebut
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
	 * @param DateTime $dateFin
	 */
	public function setDateFin(DateTime $dateFin): void
	{
		$this->dateFin = $dateFin;
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
			"statut" => $this->getStatut() ? $this->getStatut()->jsonSerialize() : null,
			"typeMission" => $this->getTypeMission() ? $this->getTypeMission()->jsonSerialize() : null,
			"specialite" => $this->getSpecialite() ? $this->getSpecialite()->jsonSerialize() : null
		];
	}
}
