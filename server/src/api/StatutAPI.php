<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/StatutDAO.php";

/**
 * Controller for statut request.
 */
class StatutAPI extends Controller implements CRUD
{
    private static ?StatutAPI $instance = null;

    /**
     * Statut singleton instance.
     */
    private function __construct()
    {
        DAOFactory::registerDAO(StatutDAO::class);
        $this->dao = DAOFactory::getDAO(StatutDAO::class);
        $this->res = new Response();
    }

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): ?StatutAPI
    {
        if (!StatutAPI::$instance) {
            StatutAPI::$instance = new StatutAPI();
        }
        return StatutAPI::$instance;
    }

    /**
     * Add a specific Statut.
     */
    public function add(): Response
    {
        /**
         * @var StatutDAO $dao
         */
        $dao = $this->dao;
		$statut = $this->deserializeModel();
        $success = $dao->add($statut);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $statut
        );
    }

    /**
     * Get all statuts.
     */
    public function getAll(): Response
    {
        /**
         * @var StatutDAO $dao
         */
        $dao = $this->dao;
        $statuts = $dao->getAll();
        $success = !is_null($statuts);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $statuts
        );
    }

    /**
     * Get a specific Statut.
     */
    public function get(): Response
    {
        /**
         * @var StatutDAO $dao
         */
        $dao = $this->dao;
        $statut = $dao->get($this->req->code);
        $success = !is_null($statut);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $statut
        );
    }

    /**
     * Update a specific Statut.
     */
    public function update(): Response
    {
        /**
         * @var StatutDAO $dao
         */
        $dao = $this->dao;
		$statut = $this->deserializeModel();
        $success = $dao->update($statut);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $statut
        );
    }

    /**
     * Delete a specific Statut.
     */
    public function delete(): Response
    {
        /**
         * @var StatutDAO $dao
         */
        $dao = $this->dao;
		$statut = $this->deserializeModel();
        $success = $dao->delete($statut);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $statut
        );
    }

	/**
	 * Deserialize the JSON request.
	 * @return Statut
	 */
	public function deserializeModel(): Statut
	{
		/**
		 * @var Statut $statut
		 * @var TypeMission $typeMission
		 */
		try
		{
			$statut = (new Deserializer(Statut::class, $this->req->statut))->deserialize();
		}
		catch (Exception $e)
		{
			print_r($e);
		}
		return $statut;
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
StatutAPI::getInstance()->response()->send();