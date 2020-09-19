<?php
require_once __DIR__ . "/../model/Contact.php";
require_once __DIR__ . "/../view/ContactView.php";

class ContactController
{
	private Contact $model;
	private ContactView $view;

	/**
	 * Initialize a ContactController with the specified model & view.
	 * @param Contact $model - The Contact model.
	 * @param ContactView $view - The Contact view.
	 */
	public function __construct(Contact $model, ContactView $view)
	{
		$this->model = $model;
		$this->view = $view;
	}

	/**
	 * Get the Contact model.
	 */
	public function getModel(): Contact
	{
		return $this->model;
	}

	/**
	 * Get the Contact view.
	 */
	public function getView(): ContactView
	{
		return $this->view;
	}

	/**
	 * Update the Contact view.
	 */
	public function updateView(): void
	{				
		$this->view->printContact();
	}	
}
