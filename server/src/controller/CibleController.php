<?php
require_once __DIR__ . "/../model/Cible.php";
require_once __DIR__ . "/../view/CibleView.php";

class CibleController
{
	private Cible $model;
	private CibleView $view;

	/**
	 * Initialize a CibleController with the specified model & view.
	 * @param Cible $model - The Cible model.
	 * @param CibleView $view - The Cible view.
	 */
	public function __construct(Cible $model, CibleView $view)
	{
		$this->model = $model;
		$this->view = $view;
	}

	/**
	 * Get the Cible model.
	 */
	public function getModel(): Cible
	{
		return $this->model;
	}

	/**
	 * Get the Cible view.
	 */
	public function getView(): CibleView
	{
		return $this->view;
	}

	/**
	 * Update the Cible view.
	 */
	public function updateView(): void
	{				
		$this->view->printCible();
	}	
}
