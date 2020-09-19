<?php
require_once __DIR__ . "/../model/Agent.php";
require_once __DIR__ . "/../view/AgentView.php";

class AgentController
{
	private Agent $model;
	private AgentView $view;

	/**
	 * Initialize a AgentController with the specified model & view.
	 * @param Agent $model - The Agent model.
	 * @param AgentView $view - The Agent view.
	 */
	public function __construct(Agent $model, AgentView $view)
	{
		$this->model = $model;
		$this->view = $view;
	}

	/**
	 * Get the Agent model.
	 */
	public function getModel(): Agent
	{
		return $this->model;
	}

	/**
	 * Get the Agent view.
	 */
	public function getView(): AgentView
	{
		return $this->view;
	}

	/**
	 * Update the Agent view.
	 */
	public function updateView(): void
	{				
		$this->view->printAgent();
	}	
}
