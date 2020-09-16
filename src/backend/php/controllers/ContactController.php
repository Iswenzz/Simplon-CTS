<?php
require "../model/Contact.php";
require "../views/ContactView.php";

class ContactController
{
	private Contact $model;
	private ContactView $view;

	public function __construct(Contact $model, ContactView $view)
	{
		$this->model = $model;
		$this->view = $view;
	}

	public function setCode(string $code)
	{
		$this->model->setCode($code);		
	}

	public function getCode()
	{
		return $this->model->getCode();	
	}

	public function updateView()
	{				
		$this->view->printContact($this->model->getCode());
	}	
}
