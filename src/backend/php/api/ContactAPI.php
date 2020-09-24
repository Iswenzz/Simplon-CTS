<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/ContactDAO.php";

/**
 * Controller for contact request.
 */
class ContactAPI extends Controller implements CRUD
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
		return $this->res->prepare(Response::OK, true,
            "Query successful", $contacts);
	}

	/**
	 * Get a specific Contact.
	 */
	private function get(): Response
	{
		/**
		 * @var ContactDAO $dao
		 * @var Contact $contact
		 */
		$dao = $this->dao;
		$contact = $dao->getContact($this->req->code);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $contact);
	}

	/**
	 * Update a specific Contact.
	 */
	private function update(): Response
    {
		/**
		 * @var ContactDAO $dao
		 * @var Contact $contact
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Contact::class, $this->req->contact);
		$contact = $deserializer->deserialize();
		$dao->updateContact($contact);
		return $this->res->prepare(Response::OK, true,
			"Query successful", $deserializer->deserialize());
	}

	/**
	 * Delete a specific Contact.
	 */
	private function delete(): Response
	{
		/**
		 * @var ContactDAO $dao
		 * @var Contact $contact
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Contact::class, $this->req->contact);
		$contact = $deserializer->deserialize();
		$dao->deleteContact($contact);
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
ContactAPI::getInstance()->response()->send();
