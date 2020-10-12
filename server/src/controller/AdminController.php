<?php
require_once __DIR__ . "/../model/Admin.php";
require_once __DIR__ . "/../view/AdminView.php";

class AdminController
{
	private Admin $model;
	private AdminView $view;

	/**
	 * Initialize a AdminController with the specified model & view.
	 * @param Admin $model - The Admin model.
	 * @param AdminView $view - The Admin view.
	 */
	public function __construct(Admin $model, AdminView $view)
	{
		$this->model = $model;
		$this->view = $view;
	}

	/**
	 * Get the Admin model.
	 */
	public function getModel(): Admin
	{
		return $this->model;
	}

	/**
	 * Get the Admin view.
	 */
	public function getView(): AdminView
	{
		return $this->view;
	}

	/**
	 * Update the Admin view.
	 */
	public function updateView(): void
	{				
		$this->view->printAdmin();
	}	
}
