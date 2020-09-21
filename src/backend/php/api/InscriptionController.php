<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/AdminDAO.php";

class InscriptionController extends Controller
{
    private static ?InscriptionController $instance = null;

    private function __construct()
    {
        DAOFactory::registerDAO(AdminDAO::class);
        $this->dao = DAOFactory::getDAO(AdminDAO::class);
        $this->response = new Response();
    }

    public static function getInstance(): ?InscriptionController
    {
        if (!InscriptionController::$instance) {
            InscriptionController::$instance = new InscriptionController();
        }
        return InscriptionController::$instance;
    }
    
    public function respond(): void
    {
        $requestBody = file_get_contents('php://input');
        if ($requestBody) {
            $requestBody = json_decode($requestBody);
            /**
             * @var AdminDAO $dao
             */
            $dao = $this->dao;
            $admin = $dao->getAdmin($requestBody->mail);
            if ($admin) {
                // admin mail already taken
                $this->response->setSuccess(false);
                $this->response->setHttpCode(Response::OK);
                $this->response->setMessage("Il existe déjà un administrateur possédant cet email !");
            } else {
                // admin mail is free -> we create a new account
                // hash the password
                $hashed = password_hash($requestBody->password, PASSWORD_DEFAULT);
                // register a new admin
                $admin = new Admin($requestBody->mail, $requestBody->name, $requestBody->firstName, new Datetime(), $hashed);
                $this->response->setSuccess($dao->addAdmin($admin));
         
                // error while registering
                if (!$this->response->getSuccess()) {
                    $this->response->setHttpCode(Response::INTERNAL_SERVER_ERROR);
                    $this->response->setMessage("Erreur lors de l'enregistrement du nouvel admin :(");
                } else {
                    $this->response->setHttpCode(Response::OK);
                    $this->response->setMessage("Enregistrement exécuté avec succès :)");
                }
            }
        } else {
            // empty request
            $this->response->setSuccess(false);
            $this->response->setHttpCode(Response::BAD_REQUEST);
            $this->response->setMessage("Mauvaise syntaxe de requête / paramètres manquants :(");
        }
        $this->response->send($admin);
    }
}
InscriptionController::getInstance()->respond();
