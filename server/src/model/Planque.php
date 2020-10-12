<?php
require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/TypePlanque.php";

class Planque extends Model implements JsonSerializable
{
    private ?int $code;
    private string $adresse;
    private ?int $codePays;
    private ?TypePlanque $typePlanque;

	/**
	 * Initialize a new Planque object.
	 * @param int|null $code
	 * @param string $adresse
	 * @param int|null $codePays
	 * @param TypePlanque|null $typePlanque
	 */
    public function __construct(?int $code = null, string $adresse = "", ?int $codePays = null, ?TypePlanque $typePlanque = null)
    {
        $this->code = $code;
        $this->adresse = $adresse;
        $this->codePays = $codePays;
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
     * Get the value of codePays
     */
    public function getCodePays(): ?int
    {
        return $this->codePays;
    }

	/**
	 * Set the value of codePays
	 * @param ?int $codePays
	 */
    public function setCodePays(?int $codePays): void
    {
        $this->codePays = $codePays;
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
            "codePays" => $this->getCodePays(),
            "typePlanque" => $this->getTypePlanque()->jsonSerialize()
        ];
    }
}