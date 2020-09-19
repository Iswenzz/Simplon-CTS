<?php
require_once __DIR__ . "/../model/Contact.php";

class ContactView 
{
	private Contact $model;

	/**
	 * Initialize a new Contact view.
	 * @param Contact $model - The Contact model.
	 */
	public function __construct(Contact $model)
	{
		$this->model = $model;
	}

	/**
	 * Print the Contact model informations.
	 */
	public function printContact(): void
	{
		print_r(sprintf("[%s] %s %s %s (%s) <br>",
			$this->model->getCode(),
			$this->model->getNom(),
			$this->model->getPrenom(),
			$this->model->getDateNaissance()->format("Y-m-d"),
			$this->model->getCodePays()
		));
	}
}
