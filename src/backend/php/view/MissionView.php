<?php
require_once __DIR__ . "/../model/Mission.php";

class MissionView 
{
	private Mission $model;

	/**
	 * Initialize a new Mission view.
	 * @param Mission $model - The Mission model.
	 */
	public function __construct(Mission $model)
	{
		$this->model = $model;
	}

	/**
	 * Print the Mission model informations.
	 */
	public function printMission(): void
	{
		print_r(sprintf("[%s] %s %s %s %s %s %s %s <br>",
			$this->model->getCode(),
			$this->model->getTitre(),
			$this->model->getDescription(),
			$this->model->getDateDebut()->format("Y-m-d"),
			$this->model->getDateFin()->format("Y-m-d"),
			$this->model->getCodeStatut(),
			$this->model->getCodeType(),
			$this->model->getCodeSpecialite()
		));
	}
}
