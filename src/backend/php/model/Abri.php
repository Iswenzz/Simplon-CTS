<?php
require_once __DIR__ . "/Model.php";

class Abri extends Model
{
	private int $codeMission;
	private int $codePlanque;

	/**
	 * Initialize a new Abri object.
	 */
	public function __construct(int $codeMission, int $codePlanque)
	{
		$this->codeMission = $codeMission;
		$this->codePlanque = $codePlanque;
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
	 * Get the value of codePlanque
	 */ 
	public function getCodePlanque(): int
	{
		return $this->codePlanque;
	}

	/**
	 * Set the value of codePlanque
	 */ 
	public function setCodePlanque(int $codePlanque): void
	{
		$this->codePlanque = $codePlanque;
	}
}
