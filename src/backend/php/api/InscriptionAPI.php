<?php
require_once __DIR__ . "/Response.php";
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../DatabaseFactory.php";
require_once __DIR__ . "/../dao/DAOFactory.php";
require_once __DIR__ . "/../dao/AdminDAO.php";

/**
 * Controller for signing up.
 */
class InscriptionAPI extends Controller
{
	private static ?InscriptionAPI $instance = null;

	/**
	 * Inscription singleton instance.
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
	public static function getInstance(): ?InscriptionAPI
	{
		if (!InscriptionAPI::$instance)
			InscriptionAPI::$instance = new InscriptionAPI();
		return InscriptionAPI::$instance;
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

		/**
		 * @var AdminDAO $dao
		 */
		$dao = $this->dao;
		$admin = $dao->getAdmin($requestBody->mail);

		// create a new admin
		if (!$admin)
		{
			// hash the password
			$hashed = password_hash($requestBody->password, PASSWORD_DEFAULT);
			// register a new admin
			$admin = new Admin($requestBody->mail, $requestBody->name, 
				$requestBody->firstName, new Datetime(), $hashed);
			$isAdminCreated = $dao->addAdmin($admin);
			$this->res->setSuccess($isAdminCreated);
		
			// error while registering
			if (!$this->res->getSuccess())
				return $this->res->prepare(Response::INTERNAL_SERVER_ERROR, false, 
					"Erreur lors de l'enregistrement du nouvel admin :(");
			return $this->res->prepare(Response::OK, true, "Enregistrement exécuté avec succès :)");
		}
		// admin mail already taken
		return $this->res->prepare(Response::OK, false, 
			"Il existe déjà un administrateur possédant cet email !");
	}
}
InscriptionAPI::getInstance()->response()->send();
