<?php
require_once __DIR__ . "/../model/Contact.php";

class ContactView 
{
	private Contact $model;

	public function __construct(Contact $model)
	{
		$this->model = $model;
	}

	/**
	 * Print the contact model informations.
	 */
	public function printContact(): void
	{
		print_r(sprintf("%s | %s | %s | %s <br>",
			$this->model->getNom(),
			$this->model->getPrenom(),
			$this->model->getDateNaissance()->format("Y-m-d"),
			$this->model->getCodePays()
		));
	}
}
