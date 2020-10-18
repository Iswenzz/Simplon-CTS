<?php
require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/TypePlanque.php";
require_once __DIR__ . "/Pays.php";

class Planque extends Model implements JsonSerializable
{
    private ?int $code;
    private string $adresse;
    private ?Pays $pays;
    private ?TypePlanque $typePlanque;

	/**
	 * Initialize a new Planque object.
	 * @param int|null $code
	 * @param string $adresse
	 * @param Pays|null $pays
	 * @param TypePlanque|null $typePlanque
	 */
    public function __construct(
    	?int $code = null,
		string $adresse = "",
		?Pays $pays = null,
		?TypePlanque $typePlanque = null)
    {
        $this->code = $code;
        $this->adresse = $adresse;
        $this->pays = $pays;
        $this->typePlanque = $typePlanque;
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
	 * Get the value of Pays
	 * @return Pays|null
	 */
	public function getPays(): ?Pays
	{
		return $this->pays;
	}

	/**
	 * Set the value of Pays
	 * @param Pays|null $pays
	 */
	public function setPays(?Pays $pays): void
	{
		$this->pays = $pays;
	}

    /**
     * Get the value of adresse
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

	/**
	 * Set the value of adresse
	 * @param string $adresse
	 */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * Get the value of typePlanque
     */
    public function getTypePlanque(): ?TypePlanque
    {
        return $this->typePlanque;
    }

	/**
	 * Set the value of typePlanque
	 * @param TypePlanque|null $typePlanque
	 */
    public function setTypePlanque(?TypePlanque $typePlanque): void
    {
        $this->typePlanque = $typePlanque;
    }

    /**
     * Serialize the object.
     */
    public function jsonSerialize()
    {
        return [
            "code" => $this->getCode(),
            "adresse" => $this->getAdresse(),
            "pays" => $this->getPays() ? $this->getPays()->jsonSerialize() : null,
            "typePlanque" => $this->getTypePlanque() ? $this->getTypePlanque()->jsonSerialize() : null
        ];
    }
}