<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/CRUD.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../Deserializer.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/SpecialiteDAO.php";

/**
 * Controller for specialite request.
 */
class SpecialiteAPI extends Controller implements CRUD
{
    private static ?SpecialiteAPI $instance = null;

    /**
     * Specialite singleton instance.
     */
    private function __construct()
    {
        DAOFactory::registerDAO(SpecialiteDAO::class);
        $this->dao = DAOFactory::getDAO(SpecialiteDAO::class);
        $this->res = new Response();
    }

    /**
     * Get the singleton instance.
     */
    public static function getInstance(): ?SpecialiteAPI
    {
        if (!SpecialiteAPI::$instance) {
            SpecialiteAPI::$instance = new SpecialiteAPI();
        }
        return SpecialiteAPI::$instance;
    }

    /**
     * Add a specific Specialite.
     */
    public function add(): Response
    {
        /**
         * @var SpecialiteDAO $dao
         * @var Specialite $specialite
         */
        $dao = $this->dao;
        $deserializer = new Deserializer(Specialite::class, $this->req->specialite);
        $specialite = $deserializer->deserialize();
        $dao->addSpecialite($specialite);
        return $this->res->prepare(
            Response::OK,
            true,
            "Add successful",
            $specialite
        );
    }

    /**
     * Get all specialites.
     */
    public function getAll(): Response
    {
        /**
         * @var SpecialiteDAO $dao
         */
        $dao = $this->dao;
        $success = $specialites = $dao->getAllSpecialites();
        $success = !is_null($success);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "GetAll successful" : "GetAll failed",
            $specialites
        );
    }

    /**
     * Get a specific Specialite.
     */
    public function get(): Response
    {
        /**
         * @var SpecialiteDAO $dao
         * @var Specialite $specialite
         */
        $dao = $this->dao;
        $success = $specialite = $dao->getSpecialite($this->req->code);
        $success = !is_null($success);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Get successful" : "Get failed",
            $specialite
        );
    }

    /**
     * Update a specific Specialite.
     */
    public function update(): Response
    {
        /**
         * @var SpecialiteDAO $dao
         * @var Specialite $specialite
         */
        $dao = $this->dao;
        $deserializer = new Deserializer(Specialite::class, $this->req->specialite);
        $specialite = $deserializer->deserialize();
        $success = $dao->updateSpecialite($specialite);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Update successful" : "Update failed",
            $specialite
        );
    }

    /**
     * Delete a specific Specialite.
     */
    public function delete(): Response
    { // TODO delete fail à cause des FK non cascadées ??
        /**
         * @var SpecialiteDAO $dao
         * @var Specialite $specialite
         */
        $dao = $this->dao;
        $deserializer = new Deserializer(Specialite::class, $this->req->specialite);
        $specialite = $deserializer->deserialize();
        $success = $dao->deleteSpecialite($specialite);
        return $this->res->prepare(
            Response::OK,
            $success,
            $success ? "Delete successful" : "Delete failed",
            $specialite
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
SpecialiteAPI::getInstance()->response()->send();