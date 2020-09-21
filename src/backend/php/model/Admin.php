<?php
require_once __DIR__ . "/../controller/AdminController.php";

class Admin
{
    private string $email;
    private string $nom;
    private string $prenom;
    private DateTime $dateCreation;
    private string $mdp;
    private ?string $apiKey;
    private ?DateTime $expirationApiKey;

    private AdminController $controller;

    /**
     * Initailize a new Admin object.
     */
    public function __construct(
        string $email,
        string $nom,
        string $prenom,
        DateTime $dateCreation,
        string $mdp,
        ?string $apiKey = null,
        ?DateTime $expirationApiKey = null
    )
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateCreation = $dateCreation;
        $this->mdp = $mdp;
        $this->email = $email;
        $this->apiKey = $apiKey;
        $this->expirationApiKey = $expirationApiKey;
        $this->controller = new AdminController($this, new AdminView($this));
    }

    /**
     * Get the Admin controller instance.
     */
    public function getController(): AdminController
    {
        return $this->controller;
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
     */
    public function setExpirationApiKey(DateTime $expirationApiKey): void
    {
        $this->expirationApiKey = $expirationApiKey;
    }
}
