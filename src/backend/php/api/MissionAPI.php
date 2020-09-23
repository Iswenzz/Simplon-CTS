<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/MissionDAO.php";

/**
 * Controller for mission requests.
 */
class MissionAPI extends Controller
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
	 * Get all Missions.
	 */
	private function getAll(): Response
	{
		/**
		 * @var MissionDAO $dao
		 */
		$dao = $this->dao;
		$Missions = $dao->getAllMissions();
		return $this->res->prepare(Response::OK, true,
            "Query successful", $Missions);
	}

	/**
	 * Update a specific Mission.
	 */
	private function update(): Response
    {
		/**
		 * @var MissionDAO $dao
		 * @var Mission $Mission
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Mission::class, $this->req->Mission);
		$Mission = $deserializer->deserialize();
		$dao->updateMission($Mission);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $deserializer->deserialize());
	}

	/**
	 * Delete a specific Mission.
	 */
	private function delete(): Response
	{
		/**
		 * @var MissionDAO $dao
		 * @var Mission $Mission
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Mission::class, $this->req->Mission);
		$Mission = $deserializer->deserialize();
		$dao->deleteMission($Mission);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $deserializer->deserialize());
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
