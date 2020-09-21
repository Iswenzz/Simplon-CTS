<?php
require_once __DIR__ . "/../model/Admin.php";

class AdminView 
{
	private Admin $model;

	/**
	 * Initialize a new Admin view.
	 * @param Admin $model - The Admin model.
	 */
	public function __construct(Admin $model)
	{
		$this->model = $model;
	}

	/**
	 * Print the Admin model informations.
	 */
	public function printAdmin(): void
	{
		print_r(sprintf("[%s] %s %s %s {%s} <br>",
			$this->model->getEmail(),
			$this->model->getNom(),
			$this->model->getPrenom(),
			$this->model->getDateCreation()->format("Y-m-d"),
			$this->model->getMdp()
		));
	}
}
