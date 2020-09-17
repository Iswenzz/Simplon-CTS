<?php
require_once __DIR__ . "/../model/Contact.php";
require_once __DIR__ . "/../view/ContactView.php";

class ContactController
{
	private Contact $model;
	private ContactView $view;

	public function __construct(Contact $model, ContactView $view)
	{
		$this->model = $model;
		$this->view = $view;
	}

	public function getModel(): Contact
	{
		return $this->model;
	}

	public function getView(): ContactView
	{
		return $this->view;
	}

	public function updateView(): void
	{				
		$this->view->printContact();
	}	
}
