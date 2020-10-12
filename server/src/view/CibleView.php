<?php
require_once __DIR__ . "/../model/Cible.php";

class CibleView 
{
	private Cible $model;

	/**
	 * Initialize a new Cible view.
	 * @param Cible $model - The Cible model.
	 */
	public function __construct(Cible $model)
	{
		$this->model = $model;
	}

	/**
	 * Print the Cible model informations.
	 */
	public function printCible(): void
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
