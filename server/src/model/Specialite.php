<?php
require_once __DIR__ . "/Model.php";

class Specialite extends Model implements JsonSerializable
{
    private ?int $code;
    private string $libelle;
    private ?TypeMission $typeMission;
    private ?string $description;

	/**
	 * Initialize a new Specialite object.
	 * @param int|null $code
	 * @param string $libelle
	 * @param TypeMission|null $typeMission
	 * @param string|null $description
	 */
    public function __construct(
    	?int $code = null,
		string $libelle = "",
		?TypeMission $typeMission = null,
		?string $description = null)
    {
        $this->code = $code;
        $this->libelle = $libelle;
        $this->typeMission = $typeMission;
        $this->description = $description;
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
     * Get the value of libelle
     */
    public function getLibelle(): string
    {
        return $this->libelle;
    }

	/**
	 * Set the value of libelle
	 * @param string $libelle
	 */
    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * Get the value of description
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     * @param ?string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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
     * Serialize the object.
     */
    public function jsonSerialize()
    {
        return [
            "code" => $this->getCode(),
            "libelle" => $this->getLibelle(),
			"description" => $this->getDescription(),
			"typeMission" => $this->getTypeMission()->jsonSerialize()
        ];
    }
}