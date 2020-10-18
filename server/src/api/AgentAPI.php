<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/AgentDAO.php";
require_once __DIR__ . "/../model/Pays.php";

/**
 * Controller for agent requests.
 */
class AgentAPI extends Controller implements CRUD
{
    private static ?AgentAPI $instance = null;

    /**
     * Agent singleton instance.
     */
    private function __construct()
    {
        DAOFactory::registerDAO(AgentDAO::class);
        $this->dao = DAOFactory::getDAO(AgentDAO::class);
        $this->res = new Response();
    }

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): ?AgentAPI
    {
        if (!AgentAPI::$instance) {
            AgentAPI::$instance = new AgentAPI();
        }
        return AgentAPI::$instance;
    }

    /**
     * Add a specific Agent.
     */
    public function get(): Response
    {
        /**
         * @var AgentDAO $dao
         * @var Agent $agent
         */
        $dao = $this->dao;
        $agent = $dao->get($this->req->code);
        $success = !is_null($agent);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $agent
        );
    }

    /**
     * Add a specific Agent.
     */
    public function add(): Response
    {
        /**
         * @var AgentDAO $dao
         */
        $dao = $this->dao;
		$agent = $this->deserializeModel();
        $success = $dao->add($agent);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Add successful" : "Add failed",
            $agent
        );
    }

    /**
     * Get all Agents.
     */
    public function getAll(): Response
    {
        /**
         * @var AgentDAO $dao
         */
        $dao = $this->dao;
        $Agents = $dao->getAll();
        $success = !is_null($Agents);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $Agents
        );
    }

    /**
     * Update a specific Agent.
     */
    public function update(): Response
    {
        /**
         * @var AgentDAO $dao
         */
        $dao = $this->dao;
		$agent = $this->deserializeModel();
        $success = !is_null($dao->update($agent));
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $agent
        );
    }

    /**
     * Delete a specific Agent.
     */
    public function delete(): Response
    {
        /**
         * @var AgentDAO $dao
         */
        $dao = $this->dao;
		$agent = $this->deserializeModel();
        $success = $dao->delete($agent);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $agent
        );
    }

	/**
	 * Deserialize the JSON request.
	 * @return Agent
	 */
	public function deserializeModel(): Agent
	{
		/**
		 * @var Agent $agent
		 * @var Pays $pays
		 */
		try
		{
			$agent = (new Deserializer(Agent::class, $this->req->agent))->deserialize();
			$pays = (new Deserializer(Pays::class, $this->req->agent->pays))->deserialize();
			$agent->setPays($pays);
		}
		catch (Exception $e)
		{
			print_r($e);
		}
		return $agent;
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
AgentAPI::getInstance()->response()->send();