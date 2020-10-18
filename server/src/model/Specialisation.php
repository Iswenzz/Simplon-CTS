<?php
require_once __DIR__ . "/Model.php";

class Specilisation extends Model
{
	private int $codeSpecialite;
	private int $codeAgent;

	/**
	 * Initialize a new Specilisation object.
	 * @param int $codeSpecialite
	 * @param int $codeAgent
	 */
	public function __construct(
		int $codeSpecialite,
		int $codeAgent)
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
	 * @param int $codeSpecialite
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
	 * @param int $codeAgent
	 */
	public function setCodeAgent(int $codeAgent): void
	{
		$this->codeAgent = $codeAgent;
	}
}
