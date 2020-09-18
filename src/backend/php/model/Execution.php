<?php

class Execution
{
	private int $codeMission;
	private int $codeAgent;

	/**
	 * Initailize a new Execution object.
	 */
	public function __construct(int $codeMission, int $codeAgent)
	{
		$this->codeMission = $codeMission;
		$this->codeAgent = $codeAgent;
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

	/**
	 * Get the value of codeMission
	 */ 
	public function getCodeMission(): int
	{
		return $this->codeMission;
	}

	/**
	 * Set the value of codeMission
	 *
	 * @return  self
	 */ 
	public function setCodeMission(int $codeMission): void
	{
		$this->codeMission = $codeMission;
	}
}
