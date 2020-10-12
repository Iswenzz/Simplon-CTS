<?php
require_once __DIR__ . "/../model/Mission.php";
require_once __DIR__ . "/../view/MissionView.php";

class MissionController
{
	private Mission $model;
	private MissionView $view;

	/**
	 * Initialize a MissionController with the specified model & view.
	 * @param Mission $model - The Mission model.
	 * @param MissionView $view - The Mission view.
	 */
	public function __construct(Mission $model, MissionView $view)
	{
		$this->model = $model;
		$this->view = $view;
	}

	/**
	 * Get the Mission model.
	 */
	public function getModel(): Mission
	{
		return $this->model;
	}

	/**
	 * Get the Mission view.
	 */
	public function getView(): MissionView
	{
		return $this->view;
	}

	/**
	 * Update the Mission view.
	 */
	public function updateView(): void
	{				
		$this->view->printMission();
	}	
}
