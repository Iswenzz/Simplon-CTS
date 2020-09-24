<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/MissionDAO.php";

/**
 * Controller for mission requests.
 */
class MissionAPI extends Controller implements CRUD
{
	private static ?MissionAPI $instance = null;

	/**
	 * Mission singleton instance.
	 */
	private function __construct()
	{
		DAOFactory::registerDAO(MissionDAO::class);
		$this->dao = DAOFactory::getDAO(MissionDAO::class);
		$this->res = new Response();
	}

	/**
	 * Get the singleton instance.
	 */
	public static function getInstance(): ?MissionAPI
	{
		if (!MissionAPI::$instance)
			MissionAPI::$instance = new MissionAPI();
		return MissionAPI::$instance;
	}

	/**
	 * Add a specific Mission.
	 */
	public function add(): Response
	{
		/**
		 * @var MissionDAO $dao
		 * @var Mission $mission
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Mission::class, $this->req->Mission);
		$mission = $deserializer->deserialize();
		$dao->add($mission);
		return $this->res->prepare(Response::OK, true,
			"Add successful", $mission);
	}

	/**
	 * Get a specific Mission.
	 */
	public function get(): Response
	{
		/**
		 * @var MissionDAO $dao
		 * @var Mission $mission
		 */
		$dao = $this->dao;
		$mission = $dao->get($this->req->code);
		return $this->res->prepare(Response::OK, true,
			"Get successful", $mission);
	}

	/**
	 * Get all Missions.
	 */
	public function getAll(): Response
	{
		/**
		 * @var MissionDAO $dao
		 */
		$dao = $this->dao;
		$missions = $dao->getAll();
		return $this->res->prepare(Response::OK, true,
            "GetAll successful", $missions);
	}

	/**
	 * Update a specific Mission.
	 */
	public function update(): Response
    {
		/**
		 * @var MissionDAO $dao
		 * @var Mission $mission
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Mission::class, $this->req->Mission);
		$mission = $deserializer->deserialize();
		$dao->update($mission);
		return $this->res->prepare(Response::OK, true,
			"Update successful", $mission);
	}

	/**
	 * Delete a specific Mission.
	 */
	public function delete(): Response
	{
		/**
		 * @var MissionDAO $dao
		 * @var Mission $mission
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Mission::class, $this->req->Mission);
		$mission = $deserializer->deserialize();
		$dao->delete($mission);
		return $this->res->prepare(Response::OK, true,
			"Delete successful", $mission);
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
MissionAPI::getInstance()->response()->send();
