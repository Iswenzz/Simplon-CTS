<?php
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/DatabaseFactory.php";
require_once __DIR__ . "/dao/DAOFactory.php";
require_once __DIR__ . "/dao/ContactDAO.php";
require_once __DIR__ . "/model/Contact.php";

DAOFactory::registerDAO(ContactDAO::class);
$contactDAO = DAOFactory::getDAO(ContactDAO::class);

/**
 * @var ContactDAO $contactDAO
 * @var Contact $contact
 */
foreach ($contactDAO->getAllContacts() as $contact)
	$contact->getController()->getView()->printContact();
