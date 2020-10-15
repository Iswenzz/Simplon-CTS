<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/PlanqueDAO.php";

/**
 * Controller for planque request.
 */
class PlanqueAPI extends Controller implements CRUD
{
    private static ?PlanqueAPI $instance = null;

    /**
     * Planque singleton instance.
     */
    private function __construct()
    {
        DAOFactory::registerDAO(PlanqueDAO::class);
        $this->dao = DAOFactory::getDAO(PlanqueDAO::class);
        $this->res = new Response();
    }

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): ?PlanqueAPI
    {
        if (!PlanqueAPI::$instance) {
            PlanqueAPI::$instance = new PlanqueAPI();
        }
        return PlanqueAPI::$instance;
    }

	/**
	 * Add a specific Planque.
	 */
    public function add(): Response
    {
        /**
         * @var PlanqueDAO $dao
         * @var Planque $planque
		 * @var TypePlanque $typePlanque
         */
        $dao = $this->dao;
        $planque = (new Deserializer(Planque::class, $this->req->planque))->deserialize();
        $typePlanque = (new Deserializer(TypePlanque::class, $this->req->planque->typePlanque))->deserialize();
        $planque->setTypePlanque($typePlanque);

        $success = $dao->add($planque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $planque
        );
    }

    /**
     * Get all planques.
     */
    public function getAll(): Response
    {
        /**
         * @var PlanqueDAO $dao
         */
        $dao = $this->dao;
        $planques = $dao->getAll();
        $success = !is_null($planques);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $planques
        );
    }

    /**
     * Get all planques.
     */
    public function getAllInCountry(): Response
    {
        /**
         * @var PlanqueDAO $dao
         */
        $dao = $this->dao;
        $planques = $dao->getAllInCountry($this->req->code);
        $success = !is_null($planques);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAllInCountry successful" : "GetAllInCountry failed",
            $planques
        );
    }

    /**
     * Get a specific Planque.
     */
    public function get(): Response
    {
        /**
         * @var PlanqueDAO $dao
         * @var Planque $planque
         */
        $dao = $this->dao;
        $planque = $dao->get($this->req->code);
        $success = !is_null($planque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $planque
        );
    }

    /**
     * Update a specific Planque.
     */
    public function update(): Response
    {
		/**
		 * @var PlanqueDAO $dao
		 * @var Planque $planque
		 * @var Pays $pays
		 * @var TypePlanque $typePlanque
		 */
		$dao = $this->dao;
		$planque = (new Deserializer(Planque::class,
			$this->req->planque))->deserialize();
		$pays = (new Deserializer(Pays::class,
			$this->req->planque->pays))->deserialize();
		$typePlanque = (new Deserializer(TypePlanque::class,
			$this->req->planque->typePlanque))->deserialize();
		$planque->setPays($pays);
		$planque->setTypePlanque($typePlanque);

        $success = $dao->update($planque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $planque
        );
    }

    /**
     * Delete a specific Planque.
     */
    public function delete(): Response
    {
		/**
		 * @var PlanqueDAO $dao
		 * @var Planque $planque
		 * @var TypePlanque $typePlanque
		 */
		$dao = $this->dao;
		$planque = (new Deserializer(Planque::class, $this->req->planque))->deserialize();
		$typePlanque = (new Deserializer(TypePlanque::class, $this->req->planque->typePlanque))->deserialize();
		$planque->setTypePlanque($typePlanque);

        $success = $dao->delete($planque);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $planque
        );
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
PlanqueAPI::getInstance()->response()->send();