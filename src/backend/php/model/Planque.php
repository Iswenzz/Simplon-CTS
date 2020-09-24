<?php
require_once __DIR__ . "/Model.php";

class Planque extends Model implements JsonSerializable
{
    private ?int $code;
    private string $adresse;
    private ?int $codePays;
    private ?int $codeTypePlanque;

    /**
     * Initialize a new Planque object.
     */
    public function __construct(?int $code = null, string $adresse = "", ?int $codePays = null, ?int $codeTypePlanque = null)
    {
        $this->code = $code;
        $this->codePays = $codePays;
        $this->codeTypePlanque = $codeTypePlanque;
        $this->adresse = $adresse;
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
     * Get the value of adresse
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
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
     * Get the value of codeTypePlanque
     */
    public function getCodeTypePlanque(): int
    {
        return $this->codeTypePlanque;
    }

    /**
     * Set the value of codeTypePlanque
     */
    public function setCodeTypePlanque(int $codeTypePlanque): void
    {
        $this->codeTypePlanque = $codeTypePlanque;
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
            "codeTypePlanque" => $this->getCodeTypePlanque()
        ];
    }
}