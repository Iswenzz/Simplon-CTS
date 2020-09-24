<?php
require_once __DIR__ . "/Model.php";

class Visee extends Model
{
	private int $codeMission;
	private int $codeCible;

	/**
	 * Initialize a new Visee object.
	 */
	public function __construct(int $codeMission, int $codeCible)
	{
		$this->codeMission = $codeMission;
		$this->codeCible = $codeCible;
	}

	/**
	 * Get the value of codeMission
	 */ 
	public function getCodeMission(): int
	{
		return $this->codeMission;
	}

	/**
	 * Set the value of codeMission
	 */ 
	public function setCodeMission(int $codeMission): void
	{
		$this->codeMission = $codeMission;
	}

	/**
	 * Get the value of codeCible
	 */ 
	public function getCodeCible(): int
	{
		return $this->codeCible;
	}

	/**
	 * Set the value of codeCible
	 */ 
	public function setCodeCible(int $codeCible): void
	{
		$this->codeCible = $codeCible;
	}
}
