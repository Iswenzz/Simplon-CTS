<?php
require_once __DIR__ . "/Model.php";

class Cible extends Model implements JsonSerializable
{
    private ?int $code;
    private string $nom;
    private string $prenom;
    private DateTime $dateNaissance;
    private int $codePays;

	/**
	 * Initialize a new Cible object.
	 * @param int|null $code
	 * @param string $nom
	 * @param string $prenom
	 * @param DateTime|null $dateNaissance
	 * @param int $codePays
	 */
    public function __construct(
    	?int $code = null,
		string $nom = "",
		string $prenom = "",
        DateTime $dateNaissance = null,
		int $codePays = 0)
	{
        $this->code = $code;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance ?? new DateTime();
        $this->codePays = $codePays;
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
     * Get the value of codePays
     */
    public function getCodePays(): int
    {
        return $this->codePays;
    }

	/**
	 * Set the value of codePays
	 * @param int $codePays
	 */
    public function setCodePays(int $codePays): void
    {
        $this->codePays = $codePays;
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
            "codePays" => $this->getCodePays()
        ];
    }
}