<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/CibleDAO.php";

/**
 * Controller for cible requests.
 */
class CibleAPI extends Controller
{
	private static ?CibleAPI $instance = null;

	/**
	 * Cible singleton instance.
	 */
	private function __construct()
	{
		DAOFactory::registerDAO(CibleDAO::class);
		$this->dao = DAOFactory::getDAO(CibleDAO::class);
		$this->res = new Response();
	}

	/**
	 * Get the singleton instance.
	 */
	public static function getInstance(): ?CibleAPI
	{
		if (!CibleAPI::$instance)
			CibleAPI::$instance = new CibleAPI();
		return CibleAPI::$instance;
	}

	/**
	 * Get a specific Cible.
	 */
	private function get(): Response
	{
		/**
		 * @var CibleDAO $dao
		 * @var Cible $cible
		 */
		$dao = $this->dao;
		$cible = $dao->getCible($this->req->code);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $cible);
	}

	/**
	 * Get all Cibles.
	 */
	private function getAll(): Response
	{
		/**
		 * @var CibleDAO $dao
		 */
		$dao = $this->dao;
		$Cibles = $dao->getAllCibles();
		return $this->res->prepare(Response::OK, true,
            "Query successful", $Cibles);
	}

	/**
	 * Update a specific Cible.
	 */
	private function update(): Response
    {
		/**
		 * @var CibleDAO $dao
		 * @var Cible $Cible
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Cible::class, $this->req->Cible);
		$Cible = $deserializer->deserialize();
		$dao->updateCible($Cible);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $deserializer->deserialize());
	}

	/**
	 * Delete a specific Cible.
	 */
	private function delete(): Response
	{
		/**
		 * @var CibleDAO $dao
		 * @var Cible $Cible
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Cible::class, $this->req->Cible);
		$Cible = $deserializer->deserialize();
		$dao->deleteCible($Cible);
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
CibleAPI::getInstance()->response()->send();
