<?php
require_once __DIR__ . "/Model.php";

class Pays extends Model implements JsonSerializable
{
	private ?int $code;
	private string $libelle;

	/**
	 * Initialize a new Pays object.
	 * @param int|null $code
	 * @param string $libelle
	 */
	public function __construct(
		?int $code = null,
		string $libelle = "")
	{
		$this->code = $code;
		$this->libelle = $libelle;
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
