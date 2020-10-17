<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/CibleDAO.php";

/**
 * Controller for cible requests.
 */
class CibleAPI extends Controller implements CRUD
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
        if (!CibleAPI::$instance) {
            CibleAPI::$instance = new CibleAPI();
        }
        return CibleAPI::$instance;
    }

    /**
     * Add a specific Cible.
     */
    public function add(): Response
    {
        /**
         * @var CibleDAO $dao
         */
        $dao = $this->dao;
		$cible = $this->deserializeModel();
        $success = $dao->add($cible);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $cible
        );
    }

    /**
     * Get a specific Cible.
     */
    public function get(): Response
    {
        /**
         * @var CibleDAO $dao
         * @var Cible $cible
         */
        $dao = $this->dao;
        $cible = $dao->get($this->req->code);
        $success = !is_null($cible);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $cible
        );
    }

    /**
     * Get all Cibles.
     */
    public function getAll(): Response
    {
        /**
         * @var CibleDAO $dao
         */
        $dao = $this->dao;
        $cibles = $dao->getAll();
        $success = !is_null($cibles);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $cibles
        );
    }

    /**
     * Update a specific Cible.
     */
    public function update(): Response
    {
        /**
         * @var CibleDAO $dao
         */
        $dao = $this->dao;
		$cible = $this->deserializeModel();
        $success = !is_null($dao->update($cible));
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $cible
        );
    }

    /**
     * Delete a specific Cible.
     */
    public function delete(): Response
    {
        /**
         * @var CibleDAO $dao
         */
        $dao = $this->dao;
		$cible = $this->deserializeModel();
        $success = $dao->delete($cible);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $cible
        );
    }

	/**
	 * Deserialize the JSON request.
	 * @return Cible
	 */
	public function deserializeModel(): Cible
	{
		/**
		 * @var Cible $cible
		 */
		try
		{
			$cible = (new Deserializer(Cible::class, $this->req->pays))->deserialize();
		}
		catch (Exception $e)
		{
			print_r(e);
		}
		return $cible;
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
CibleAPI::getInstance()->response()->send();