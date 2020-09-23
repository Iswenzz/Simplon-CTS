<?php

class Pays implements JsonSerializable
{
	private ?int $code;
	private string $libelle;

	/**
	 * Initailize a new Pays object.
	 */
	public function __construct(?int $code, string $libelle)
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
