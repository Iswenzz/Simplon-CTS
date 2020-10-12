<?php
require_once __DIR__ . "/../model/Agent.php";

class AgentView 
{
	private Agent $model;

	/**
	 * Initialize a new Agent view.
	 * @param Agent $model - The Agent model.
	 */
	public function __construct(Agent $model)
	{
		$this->model = $model;
	}

	/**
	 * Print the Agent model informations.
	 */
	public function printAgent(): void
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
