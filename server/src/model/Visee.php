<?php
require_once __DIR__ . "/Model.php";

class Visee extends Model
{
	private ?int $codeMission;
	private ?int $codeCible;

	/**
	 * Initialize a new Visee object.
	 * @param ?int $codeMission
	 * @param ?int $codeCible
	 */
	public function __construct(
		?int $codeMission = null,
		?int $codeCible = null)
	{
		$this->codeMission = $codeMission;
		$this->codeCible = $codeCible;
	}

	/**
	 * Get the value of codeMission
	 */ 
	public function getCodeMission(): ?int
	{
		return $this->codeMission;
	}

	/**
	 * Set the value of codeMission
	 * @param ?int $codeMission
	 */
	public function setCodeMission(?int $codeMission): void
	{
		$this->codeMission = $codeMission;
	}

	/**
	 * Get the value of codeCible
	 */ 
	public function getCodeCible(): ?int
	{
		return $this->codeCible;
	}

	/**
	 * Set the value of codeCible
	 * @param ?int $codeCible
	 */
	public function setCodeCible(?int $codeCible): void
	{
		$this->codeCible = $codeCible;
	}
}
