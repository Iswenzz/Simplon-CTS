<?php
require "../model/Contact.php";

class ContactView 
{
	private Contact $model;

	public function __construct(Contact $model)
	{
		$this->model = $model;
	}

	public function printContact(): void
	{
		print_r("Contact:");
		print_r("[Code] " . $this->model->getCode());
	}
}
