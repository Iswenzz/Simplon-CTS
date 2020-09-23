<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/AdminDAO.php";

/**
 * Controller for login requests.
 */
class ConnectionAPI extends Controller
{
	private static ?ConnectionAPI $instance = null;

	/**
	 * Connection singleton instance.
	 */
	private function __construct()
	{
		DAOFactory::registerDAO(AdminDAO::class);
		$this->dao = DAOFactory::getDAO(AdminDAO::class);
		$this->res = new Response();
	}

	/**
	 * Get the singleton instance.
	 */
	public static function getInstance(): ?ConnectionAPI
	{
		if (!ConnectionAPI::$instance)
			ConnectionAPI::$instance = new ConnectionAPI();
		return ConnectionAPI::$instance;
	}

	/**
	 * Prepare the request response.
	 */
	public function response(): Response
	{
		$requestBody = file_get_contents('php://input');
		if (!$requestBody) // empty request
			return $this->res->prepare(Response::BAD_REQUEST, false, 
				"Mauvaise syntaxe de requête / paramètres manquants :(");
		$requestBody = json_decode($requestBody);
		$this->req = $requestBody;

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
				$this->res->setMessage("Identifiants valides :)");
				$isValidKey = false;

				// check if this admin already has a valid API key
				if (!is_null($admin->getExpirationApiKey()) && !is_null($admin->getApiKey())) 
				{
					$expirationDate = $admin->getExpirationApiKey();
					$now = new Datetime();
					$isValidKey = $now->diff($expirationDate)->format("%R") == "+"; // the diff is positive
				} 
		
				// no valid key -> generating a new one
				if (!$isValidKey) 
				{
					$admin->setApiKey(random_bytes(31));
					$isUpdated = $dao->updateApiKey($admin);
					$this->res->prepare(Response::OK, $isUpdated, "Nouvelle clé générée");

					// DB error during generation
					if (!$this->res->getSuccess())
						return $this->res->prepare(Response::INTERNAL_SERVER_ERROR, false, 
							"Erreur lors de la génération de clé de connexion :(");
				} 
				else // reading existing key
					$this->res->setMessage("Récupération de la clé");

				// response success
				return $this->res->prepare(Response::OK, true, "Connection réussi!", json_encode([
					"key" => $admin->getApiKey(),
					"user" => $admin->getEmail()
				]));
			} 
			// bad password
			return $this->res->prepare(Response::OK, false, 
				"Mauvais mot de passe :(");
		} 
		// no mail/password match
		return $this->res->prepare(Response::OK, false, 
			"Aucun admin existant avec cet email :(");
	}
}
ConnectionAPI::getInstance()->response()->send();
