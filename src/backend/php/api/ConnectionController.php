<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
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
		$this->response = new Response();
	}

	public static function getInstance(): ?ConnectionController
	{
		if (!ConnectionController::$instance)
			ConnectionController::$instance = new ConnectionController();
		return ConnectionController::$instance;
	}

	public function respond(): void
	{
		$requestBody = file_get_contents('php://input');
		if (!$requestBody) // empty request
		{
			$this->response->prepare(Response::BAD_REQUEST, false, 
				"Mauvaise syntaxe de requête / paramètres manquants :(")->send();
			return;
		}
		$requestBody = json_decode($requestBody);
		/**
		 * @var AdminDAO $dao
		 */
		$dao = $this->dao;
		$admin = $dao->getAdmin($requestBody->mail);
		if ($admin) 
		{
			if (password_verify($requestBody->motDePasse, $admin->getMdp())) 
			{
				$admin->setEmail($requestBody->mail);
				$admin->setMdp($requestBody->motDePasse);
				$this->response->setMessage("Identifiants valides :)");

				// check if this admin already has a valid API key
				if (!is_null($admin->getExpirationApiKey()) && !is_null($admin->getApiKey())) {
					$expirationDate = $admin->getExpirationApiKey();
					$now = new Datetime();
					$isValidKey = $now->diff($expirationDate)->format("%R") == "+"; // the diff is positive
				} 
				else
					$isValidKey = false;
		
				// no valid key -> generating a new one
				if (!$isValidKey) 
				{
					$admin->setApiKey(random_bytes(31));
					$this->response->prepare(Response::OK, $dao->updateApiKey($admin), 
						"Nouvelle clé générée");

					// DB error during generation
					if (!$this->response->getSuccess())
						$this->response->prepare(Response::INTERNAL_SERVER_ERROR, false, 
							"Erreur lors de la génération de clé de connexion :(")->send();
				} 
				else // reading existing key
					$this->response->setMessage("Récupération de la clé");
				// response success
				$this->response->prepare(Response::OK, true, "Connection réussi!")->send([
					"key" => $admin->getApiKey() ?? "",
					"user" => $admin->getEmail() ?? ""
				]);
			} 
			else // bad password
				$this->response->prepare(Response::OK, false, 
					"Mauvais mot de passe :(")->send();
		} 
		else // no mail/password match
			$this->response->prepare(Response::OK, false, 
				"Aucun admin existant avec cet email :(")->send();
	}
}
ConnectionController::getInstance()->respond();
