<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/TypePlanqueDAO.php";

/**
 * Controller for typePlanque request.
 */
class TypePlanqueAPI extends Controller implements CRUD
{
    private static ?TypePlanqueAPI $instance = null;

    /**
     * TypePlanque singleton instance.
     */
    private function __construct()
    {
        DAOFactory::registerDAO(TypePlanqueDAO::class);
        $this->dao = DAOFactory::getDAO(TypePlanqueDAO::class);
        $this->res = new Response();
    }

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): ?TypePlanqueAPI
    {
        if (!TypePlanqueAPI::$instance) {
            TypePlanqueAPI::$instance = new TypePlanqueAPI();
        }
        return TypePlanqueAPI::$instance;
    }

    /**
     * Add a specific TypePlanque.
     */
    public function add(): Response
    {
        /**
         * @var TypePlanqueDAO $dao
         */
        $dao = $this->dao;
		$typePlanque = $this->deserializeModel();
        $success = $dao->add($typePlanque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $typePlanque
        );
    }

    /**
     * Get all typePlanques.
     */
    public function getAll(): Response
    {
        /**
         * @var TypePlanqueDAO $dao
         */
        $dao = $this->dao;
        $typePlanques = $dao->getAll();
        $success = !is_null($typePlanques);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $typePlanques
        );
    }

    /**
     * Get a specific TypePlanque.
     */
    public function get(): Response
    {
        /**
         * @var TypePlanqueDAO $dao
         */
        $dao = $this->dao;
        $typePlanque = $dao->get($this->req->code);
        $success = !is_null($typePlanque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $typePlanque
        );
    }

    /**
     * Update a specific TypePlanque.
     */
    public function update(): Response
    {
        /**
         * @var TypePlanqueDAO $dao
         */
        $dao = $this->dao;
		$typePlanque = $this->deserializeModel();
        $success = $dao->update($typePlanque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $typePlanque
        );
    }

    /**
     * Delete a specific TypePlanque.
     */
    public function delete(): Response
    {
        /**
         * @var TypePlanqueDAO $dao
         */
        $dao = $this->dao;
		$typePlanque = $this->deserializeModel();
        $success = $dao->delete($typePlanque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $typePlanque
        );
    }

	/**
	 * Deserialize the JSON request.
	 * @return TypePlanque
	 */
	public function deserializeModel(): TypePlanque
	{
		/**
		 * @var TypePlanque $typePlanque
		 * @var TypeMission $typeMission
		 */
		try
		{
			$typePlanque = (new Deserializer(TypePlanque::class, $this->req->typePlanque))->deserialize();
		}
		catch (Exception $e)
		{
			print_r($e);
		}
		return $typePlanque;
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
TypePlanqueAPI::getInstance()->response()->send();