<?php

class Planque
{
	private ?int $code;
	private string $adresse;
	private int $codePays;
	private int $codeType;

	/**
	 * Initailize a new Planque object.
	 */
	public function __construct(?int $code, string $adresse, int $codePays, int $codeType)
	{
		$this->code = $code;
		$this->codePays = $codePays;
		$this->codeType = $codeType;
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
	 * Get the value of codeType
	 */ 
	public function getCodeType(): int
	{
		return $this->codeType;
	}

	/**
	 * Set the value of codeType
	 */ 
	public function setCodeType(int $codeType): void
	{
		$this->codeType = $codeType;
	}
}
