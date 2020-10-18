<?php
require_once __DIR__ . "/Model.php";

class Aide extends Model
{
	private ?int $codeMission;
	private ?int $codeContact;

	/**
	 * Initialize a new Aide object.
	 * @param ?int $codeMission
	 * @param ?int $codeContact
	 */
	public function __construct(
		?int $codeMission = null,
		?int $codeContact = null)
	{
		$this->codeMission = $codeMission;
		$this->codeContact = $codeContact;
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
	 * Get the value of codeContact
	 */ 
	public function getCodeContact(): ?int
	{
		return $this->codeContact;
	}

	/**
	 * Set the value of codeContact
	 * @param ?int $codeContact
	 */
	public function setCodeContact(?int $codeContact): void
	{
		$this->codeContact = $codeContact;
	}
}
