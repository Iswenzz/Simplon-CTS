<?php
require_once __DIR__ . "/Model.php";

class Admin extends Model implements JsonSerializable
{
    private string $email;
    private string $nom;
    private string $prenom;
    private DateTime $dateCreation;
    private string $mdp;
    private ?string $apiKey;
    private ?DateTime $expirationApiKey;

	/**
	 * Initialize a new Admin object.
	 * @param string $email
	 * @param string $nom
	 * @param string $prenom
	 * @param DateTime $dateCreation
	 * @param string $mdp
	 * @param string|null $apiKey
	 * @param DateTime|null $expirationApiKey
	 */
    public function __construct(
        string $email,
        string $nom,
        string $prenom,
        DateTime $dateCreation,
        string $mdp,
        ?string $apiKey = null,
        ?DateTime $expirationApiKey = null)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateCreation = $dateCreation;
        $this->mdp = $mdp;
        $this->email = $email;
        $this->apiKey = $apiKey;
        $this->expirationApiKey = $expirationApiKey;
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
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

	/**
	 * Set the value of dateNaissance.
	 * @param DateTime $dateCreation
	 */
    public function setDateCreation(DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Get the value of mdp
     */
    public function getMdp(): string
    {
        return $this->mdp;
    }

	/**
	 * Set the value of mdp
	 * @param string $mdp
	 */
    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

	/**
	 * Set the value of email
	 * @param string $email
	 */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the value of apiKey
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

	/**
	 * Set the value of apiKey
	 * @param string $apiKey
	 */
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get the value of expirationApiKey
     */
    public function getExpirationApiKey(): DateTime
    {
        return $this->expirationApiKey;
    }

	/**
	 * Set the value of expirationApiKey
	 * @param DateTime $expirationApiKey
	 */
    public function setExpirationApiKey(DateTime $expirationApiKey): void
	{
		$this->expirationApiKey = $expirationApiKey;
	}

	/**
	 * Serialize the object.
	 */
	public function jsonSerialize(): array
	{
		return [
			"email" => $this->getEmail(),
			"nom" => $this->getNom(),
			"prenom" => $this->getPrenom(),
			"dateCreation" => $this->getDateCreation()->format("Y-m-d"),
			"mdp" => $this->getMdp(),
			"apiKey" => $this->getApiKey(),
			"expirationApiKey" => $this->getExpirationApiKey()
		];
	}
}
