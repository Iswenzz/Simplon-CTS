<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/TypeMissionDAO.php";

/**
 * Controller for typeMission request.
 */
class TypeMissionAPI extends Controller implements CRUD
{
    private static ?TypeMissionAPI $instance = null;

    /**
     * TypeMission singleton instance.
     */
    private function __construct()
    {
        DAOFactory::registerDAO(TypeMissionDAO::class);
        $this->dao = DAOFactory::getDAO(TypeMissionDAO::class);
        $this->res = new Response();
    }

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): ?TypeMissionAPI
    {
        if (!TypeMissionAPI::$instance) {
            TypeMissionAPI::$instance = new TypeMissionAPI();
        }
        return TypeMissionAPI::$instance;
    }

    /**
     * Add a specific TypeMission.
     */
    public function add(): Response
    {
        /**
         * @var TypeMissionDAO $dao
         */
        $dao = $this->dao;
		$typeMission = $this->deserializeModel();
        $success = $dao->add($typeMission);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $typeMission
        );
    }

    /**
     * Get all typeMissions.
     */
    public function getAll(): Response
    {
        /**
         * @var TypeMissionDAO $dao
         */
        $dao = $this->dao;
        $typeMissions = $dao->getAll();
        $success = !is_null($typeMissions);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $typeMissions
        );
    }

    /**
     * Get a specific TypeMission.
     */
    public function get(): Response
    {
        /**
         * @var TypeMissionDAO $dao
         */
        $dao = $this->dao;
        $typeMission = $dao->get($this->req->code);
        $success = !is_null($typeMission);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $typeMission
        );
    }

    /**
     * Update a specific TypeMission.
     */
    public function update(): Response
    {
        /**
         * @var TypeMissionDAO $dao
         */
        $dao = $this->dao;
		$typeMission = $this->deserializeModel();
        $success = $dao->update($typeMission);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $typeMission
        );
    }

    /**
     * Delete a specific TypeMission.
     */
    public function delete(): Response
    {
        /**
         * @var TypeMissionDAO $dao
         */
        $dao = $this->dao;
		$typeMission = $this->deserializeModel();
        $success = $dao->delete($typeMission);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $typeMission
        );
    }

	/**
	 * Deserialize the JSON request.
	 * @return TypeMission
	 */
	public function deserializeModel(): TypeMission
	{
		/**
		 * @var TypeMission $typeMission
		 * @var TypeMission $typeMission
		 */
		try
		{
			$typeMission = (new Deserializer(TypeMission::class, $this->req->typeMission))->deserialize();
		}
		catch (Exception $e)
		{
			print_r($e);
		}
		return $typeMission;
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
TypeMissionAPI::getInstance()->response()->send();