<?php

class Aide
{
	private int $codeMission;
	private int $codeContact;

	/**
	 * Initialize a new Aide object.
	 */
	public function __construct(int $codeMission, int $codeContact)
	{
		$this->codeMission = $codeMission;
		$this->codeContact = $codeContact;
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
	 * Get the value of codeContact
	 */ 
	public function getCodeContact(): int
	{
		return $this->codeContact;
	}

	/**
	 * Set the value of codeContact
	 */ 
	public function setCodeContact(int $codeContact): void
	{
		$this->codeContact = $codeContact;
	}
}
