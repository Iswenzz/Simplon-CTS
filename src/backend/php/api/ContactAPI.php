<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/ContactDAO.php";

/**
 * Controller for login requests.
 */
class ContactAPI extends Controller
{
	private static ?ContactAPI $instance = null;

	/**
	 * Contact singleton instance.
	 */
	private function __construct()
	{
		DAOFactory::registerDAO(ContactDAO::class);
		$this->dao = DAOFactory::getDAO(ContactDAO::class);
		$this->res = new Response();
	}

	/**
	 * Get the singleton instance.
	 */
	public static function getInstance(): ?ContactAPI
	{
		if (!ContactAPI::$instance)
			ContactAPI::$instance = new ContactAPI();
		return ContactAPI::$instance;
	}

	/**
	 * Get all contacts.
	 */
	private function getAll(): Response
	{
		/**
		 * @var ContactDAO $dao
		 */
		$dao = $this->dao;
		$contacts = $dao->getAllContacts();
		return $this->res->prepare(Response::OK, true, "Query successful", $contacts);
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

		switch ($requestBody->method)
		{
			case "all": return $this->getAll();
		}
	}
}
ContactAPI::getInstance()->response()->send();
