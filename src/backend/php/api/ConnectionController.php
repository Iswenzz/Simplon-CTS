<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/ConnectionResponse.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/AdminDAO.php";

class ConnectionController extends Controller
{
    private static ?ConnectionController $instance = null;

    private function __construct()
    {
        DAOFactory::registerDAO(AdminDAO::class);
        $this->dao = DAOFactory::getDAO(AdminDAO::class);
        $this->response = new ConnectionResponse();
    }

    public static function getInstance(): ?ConnectionController
    {
        if (!ConnectionController::$instance) {
            ConnectionController::$instance = new ConnectionController();
        }
        return ConnectionController::$instance;
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
                if (password_verify($requestBody->motDePasse, $admin->getMdp())) {
                    $admin->setEmail($requestBody->mail);
                    $admin->setMdp($requestBody->motDePasse);

                    $this->response->setHttpCode(Response::OK);
                    $this->response->setMessage("Identifiants valides :)");
                    $this->response->setSuccess(true);
                    
                    // check if this admin already has a valid API key
                    if (!is_null($admin->getExpirationApiKey()) && !is_null($admin->getApiKey())) {
                        $expirationDate = $admin->getExpirationApiKey();
                        $now = new Datetime();
                        $isValidKey = $now->diff($expirationDate)->format("%R") == "+"; // the diff is positive
                    } else {
                        $isValidKey = false;
                    }
            
            
                    // no valid key -> generating a new one
                    if (!$isValidKey) {
                        $this->response->setMessage("Nouvelle clé générée");
                        $key = random_bytes(31);
                        $this->response->setSuccess($dao->updateApiKey($admin));

                        // DB error during generation
                        if (!$this->response->getSuccess()) {
                            $this->response->setHttpCode(Response::INTERNAL_SERVER_ERROR);
                            $this->response->setMessage("Erreur lors de la génération de clé de connexion :(");
                        }
                    } else {
                        // reading existing key
                        $this->response->setMessage("Récupération de la clé");
                    }
                } else {	// bad password
                    $this->response->setSuccess(false);
                    $this->response->setHttpCode(Response::OK);
                    $this->response->setMessage("Mauvais mot de passe :(");
                }
            } else {	// no mail/password match
                $this->response->setSuccess(false);
                $this->response->setHttpCode(Response::OK);
                $this->response->setMessage("Aucun admin existant avec cet email :(");
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
ConnectionController::getInstance()->respond();
