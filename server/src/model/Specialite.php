<?php
require_once __DIR__ . "/Model.php";

class Specialite extends Model implements JsonSerializable
{
    private ?int $code;
    private string $libelle;
    private ?int $codeTypeMission;
    private ?string $description;

    /**
     * Initialize a new Specialite object.
     */
    public function __construct(?int $code = null, string $libelle = "", ?int $codeTypeMission = null, ?string $description = "")
    {
        $this->code = $code;
        $this->libelle = $libelle;
        $this->codeTypeMission = $codeTypeMission;
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
     */
    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * Get the value of description
     * @return string
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
     * Get the value of codeTypeMission
     */
    public function getCodeTypeMission()
    {
        return $this->codeTypeMission;
    }

    /**
     * Set the value of codeTypeMission
     *
     * @return  self
     */
    public function setCodeTypeMission($codeTypeMission)
    {
        $this->codeTypeMission = $codeTypeMission;

        return $this;
    }
    
    /**
     * Serialize the object.
     */
    public function jsonSerialize()
    {
        return [
            "code" => $this->getCode(),
            "libelle" => $this->getLibelle()
        ];
    }
}