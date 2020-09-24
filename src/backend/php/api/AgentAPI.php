<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/AgentDAO.php";

/**
 * Controller for agent requests.
 */
class AgentAPI extends Controller implements CRUD
{
	private static ?AgentAPI $instance = null;

	/**
	 * Agent singleton instance.
	 */
	private function __construct()
	{
		DAOFactory::registerDAO(AgentDAO::class);
		$this->dao = DAOFactory::getDAO(AgentDAO::class);
		$this->res = new Response();
	}

	/**
	 * Get the singleton instance.
	 */
	public static function getInstance(): ?AgentAPI
	{
		if (!AgentAPI::$instance)
			AgentAPI::$instance = new AgentAPI();
		return AgentAPI::$instance;
	}

	/**
	 * Add a specific Agent.
	 */
	public function get(): Response
	{
		/**
		 * @var AgentDAO $dao
		 * @var Agent $agent
		 */
		$dao = $this->dao;
		$agent = $dao->getAgent($this->req->code);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $agent);
	}

	/**
	 * Add a specific Agent.
	 */
	public function add(): Response
	{
		/**
		 * @var AgentDAO $dao
		 * @var Agent $agent
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Agent::class, $this->req->Agent);
		$agent = $deserializer->deserialize();
		$dao->addAgent($agent);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $agent);
	}

	/**
	 * Get all Agents.
	 */
	public function getAll(): Response
	{
		/**
		 * @var AgentDAO $dao
		 */
		$dao = $this->dao;
		$Agents = $dao->getAllAgents();
		return $this->res->prepare(Response::OK, true,
            "Query successful", $Agents);
	}

	/**
	 * Update a specific Agent.
	 */
	public function update(): Response
    {
		/**
		 * @var AgentDAO $dao
		 * @var Agent $agent
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Agent::class, $this->req->Agent);
		$agent = $deserializer->deserialize();
		$dao->updateAgent($agent);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $agent);
	}

	/**
	 * Delete a specific Agent.
	 */
	public function delete(): Response
	{
		/**
		 * @var AgentDAO $dao
		 * @var Agent $agent
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Agent::class, $this->req->Agent);
		$agent = $deserializer->deserialize();
		$dao->deleteAgent($agent);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $agent);
	}

	/**
	 * Prepare the request response.
	 */
	public function response(): Response
	{
		$requestBody = file_get_contents('php://input');
		if (!$requestBody) // empty request
			return $this->res->prepare(Response::BAD_REQUEST, false,
				"Mauvaise syntaxe de requête / paramètres manquants :(");
		$requestBody = json_decode($requestBody);
		$this->req = $requestBody;

		// call the right response callback
		return call_user_func([$this, $requestBody->method]);
	}
}
AgentAPI::getInstance()->response()->send();
