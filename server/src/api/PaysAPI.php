<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/PaysDAO.php";

/**
 * Controller for pays request.
 */
class PaysAPI extends Controller implements CRUD
{
    private static ?PaysAPI $instance = null;

    /**
     * Pays singleton instance.
     */
    private function __construct()
    {
        DAOFactory::registerDAO(PaysDAO::class);
        $this->dao = DAOFactory::getDAO(PaysDAO::class);
        $this->res = new Response();
    }

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): ?PaysAPI
    {
        if (!PaysAPI::$instance) {
            PaysAPI::$instance = new PaysAPI();
        }
        return PaysAPI::$instance;
    }

    /**
     * Add a specific Pays.
     */
    public function add(): Response
    {
        /**
         * @var PaysDAO $dao
         */
        $dao = $this->dao;
        $pays = $this->deserializeModel();
        $success = $dao->add($pays);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $pays
        );
    }

    /**
     * Get all payss.
     */
    public function getAll(): Response
    {
        /**
         * @var PaysDAO $dao
         */
        $dao = $this->dao;
        $pays = $dao->getAll();
        $success = !is_null($pays);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $pays
        );
    }

    /**
     * Get a specific Pays.
     */
    public function get(): Response
    {
        /**
         * @var PaysDAO $dao
         */
        $dao = $this->dao;
        $pays = $dao->get($this->req->code);
        $success = !is_null($pays);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $pays
        );
    }

    /**
     * Update a specific Pays.
     */
    public function update(): Response
    {
        /**
         * @var PaysDAO $dao
         */
        $dao = $this->dao;
		$pays = $this->deserializeModel();
        $success = $dao->update($pays);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $pays
        );
    }

    /**
     * Delete a specific Pays.
     */
    public function delete(): Response
    {
        /**
         * @var PaysDAO $dao
         */
        $dao = $this->dao;
		$pays = $this->deserializeModel();
        $success = $dao->delete($pays);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $pays
        );
    }

	/**
	 * Deserialize the JSON request.
	 * @return Pays
	 */
	public function deserializeModel(): Pays
	{
		/**
		 * @var Pays $pays
		 */
		try
		{
			$pays = (new Deserializer(Pays::class, $this->req->pays))->deserialize();
		}
		catch (Exception $e)
		{
			print_r($e);
		}
		return $pays;
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
PaysAPI::getInstance()->response()->send();