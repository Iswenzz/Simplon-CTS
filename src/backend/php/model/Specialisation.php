<?php

class Specilisation
{
	private int $codeSpecialite;
	private int $codeAgent;

	/**
	 * Initailize a new Specilisation object.
	 */
	public function __construct(int $codeSpecialite, int $codeAgent)
	{
		$this->codeSpecialite = $codeSpecialite;
		$this->codeAgent = $codeAgent;
	}

	/**
	 * Get the value of codeSpecialite
	 */ 
	public function getCodeSpecialite(): int
	{
		return $this->codeSpecialite;
	}

	/**
	 * Set the value of codeSpecialite
	 */ 
	public function setCodeSpecialite(int $codeSpecialite): void
	{
		$this->codeSpecialite = $codeSpecialite;
	}

	/**
	 * Get the value of codeAgent
	 */ 
	public function getCodeAgent(): int
	{
		return $this->codeAgent;
	}

	/**
	 * Set the value of codeAgent
	 */ 
	public function setCodeAgent(int $codeAgent): void
	{
		$this->codeAgent = $codeAgent;
	}
}