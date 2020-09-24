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
	 * Add a specific Contact.
	 */
	public function add(): Response
	{
		/**
		 * @var ContactDAO $dao
		 * @var Contact $contact
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Contact::class, $this->req->Contact);
		$contact = $deserializer->deserialize();
		$dao->add($contact);
		return $this->res->prepare(Response::OK, true,
			"Add successful", $contact);
	}

	/**
	 * Get all contacts.
	 */
	public function getAll(): Response
	{
		/**
		 * @var ContactDAO $dao
		 */
		$dao = $this->dao;
		$contacts = $dao->getAll();
		return $this->res->prepare(Response::OK, true,
            "GetAll successful", $contacts);
	}

	/**
	 * Get a specific Contact.
	 */
	public function get(): Response
	{
		/**
		 * @var ContactDAO $dao
		 * @var Contact $contact
		 */
		$dao = $this->dao;
		$contact = $dao->get($this->req->code);
		return $this->res->prepare(Response::OK, true,
			"Get successful", $contact);
	}

	/**
	 * Update a specific Contact.
	 */
	public function update(): Response
    {
		/**
		 * @var ContactDAO $dao
		 * @var Contact $contact
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Contact::class, $this->req->contact);
		$contact = $deserializer->deserialize();
		$dao->update($contact);
		return $this->res->prepare(Response::OK, true,
			"Update successful", $contact);
	}

	/**
	 * Delete a specific Contact.
	 */
	public function delete(): Response
	{
		/**
		 * @var ContactDAO $dao
		 * @var Contact $contact
		 */
		$dao = $this->dao;
		$deserializer = new Deserializer(Contact::class, $this->req->contact);
		$contact = $deserializer->deserialize();
		$dao->delete($contact);
		return $this->res->prepare(Response::OK, true,
			"Delete successful", $contact);
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
