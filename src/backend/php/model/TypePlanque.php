<?php

class TypePlanque implements JsonSerializable
{
	private ?int $code;
	private string $libelle;
	private string $description;

	/**
	 * Initailize a new TypePlanque object.
	 */
	public function __construct(?int $code, string $libelle, string $description)
	{
		$this->code = $code;
		$this->libelle = $libelle;
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
