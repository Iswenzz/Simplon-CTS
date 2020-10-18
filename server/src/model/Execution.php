<?php
require_once __DIR__ . "/Model.php";

class Execution extends Model
{
	private ?int $codeMission;
	private ?int $codeAgent;

	/**
	 * Initialize a new Execution object.
	 * @param ?int $codeMission
	 * @param ?int $codeAgent
	 */
	public function __construct(
		?int $codeMission = null,
		?int $codeAgent = null)
	{
		$this->codeMission = $codeMission;
		$this->codeAgent = $codeAgent;
	}

	/**
	 * Get the value of codeAgent
	 */ 
	public function getCodeAgent(): ?int
	{
		return $this->codeAgent;
	}

	/**
	 * Set the value of codeAgent
	 * @param ?int $codeAgent
	 */
	public function setCodeAgent(?int $codeAgent): void
	{
		$this->codeAgent = $codeAgent;
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
}
