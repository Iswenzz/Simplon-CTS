<?php

class Contact
{
	private int $code;
	private string $nom;
	private string $prenom;
	private DateTime $dateNaissance;
	private int $codePays;

	public function getCode()
	{
		return $this->code;
	}

	public function setCode($code) 
	{
		$this->code = $code;
	}
}
