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
        if (!ContactAPI::$instance) {
            ContactAPI::$instance = new ContactAPI();
        }
        return ContactAPI::$instance;
    }

    /**
     * Add a specific Contact.
     */
    public function add(): Response
    {
        /**
         * @var ContactDAO $dao
         */
        $dao = $this->dao;
		$contact = $this->deserializeModel();
        $success = $dao->add($contact);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $contact
        );
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
        $success = !is_null($contacts);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $contacts
        );
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
        $success = !is_null($contact);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $contact
        );
    }

    /**
     * Update a specific Contact.
     */
    public function update(): Response
    {
        /**
         * @var ContactDAO $dao
         */
        $dao = $this->dao;
		$contact = $this->deserializeModel();
        $success = !is_null($dao->update($contact));
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $contact
        );
    }

    /**
     * Delete a specific Contact.
     */
    public function delete(): Response
    {
        /**
         * @var ContactDAO $dao
         */
        $dao = $this->dao;
		$contact = $this->deserializeModel();
        $success = $dao->delete($contact);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $contact
        );
    }

	/**
	 * Deserialize the JSON request.
	 * @return Contact
	 */
	public function deserializeModel(): Contact
	{
		/**
		 * @var Contact $contact
		 */
		try
		{
			$contact = (new Deserializer(Contact::class, $this->req->pays))->deserialize();
		}
		catch (Exception $e)
		{
			print_r(e);
		}
		return $contact;
	}

    /**
     * Prepare the request response.
     */
    public function response(): Response
    {
        $requestBody = file_get_contents('php://input');
        if (!$requestBody) { // empty request
            return $this->res->prepare(
                Response::BAD_REQUEST,
                false,
                "Mauvaise syntaxe de requête / paramètres manquants :("
            );
        }
        $requestBody = json_decode($requestBody);
        $this->req = $requestBody;

        // call the right response callback
        return call_user_func([$this, $requestBody->method]);
    }
}
ContactAPI::getInstance()->response()->send();