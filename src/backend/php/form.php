<?php
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/DatabaseFactory.php";
require_once __DIR__ . "/dao/DAOFactory.php";
require_once __DIR__ . "/dao/ContactDAO.php";
require_once __DIR__ . "/model/Contact.php";

DAOFactory::registerDAO(ContactDAO::class);
/**
 * @var ContactDAO $contactDAO
 */
$contactDAO = DAOFactory::getDAO(ContactDAO::class);

// var_dump($contactDAO->addContact(new Contact(null, "Test", "Yeet", 
// 	DateTime::createFromFormat("Y-m-d", "1970-01-01"), 28)));
// var_dump($contactDAO->deleteContact(new Contact(73, "Test", "Yeet", 
// 	DateTime::createFromFormat("Y-m-d", "1970-01-01"), 28)));
// var_dump($contactDAO->updateContact(new Contact(75, "Test", "Yeet", 
// 	DateTime::createFromFormat("Y-m-d", "1970-01-01"), 40)));

/**
 * @var Contact $contact
 */
foreach ($contactDAO->getAllContacts() as $contact)
	$contact->getController()->getView()->printContact();
