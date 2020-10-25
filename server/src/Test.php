<?php

require_once __DIR__ . "/dao/MissionDAO.php";
require_once __DIR__ . "/dao/DAOFactory.php";

DAOFactory::registerDAO(MissionDAO::class);
/**
 * @var MissionDAO $dao
 */
$dao = DAOFactory::getDAO(MissionDAO::class);
$result = $dao->getAllByContact(1);

// UPDATE
//$update = $result[0];
//$update->setLibelle($update->getLibelle() . " test");
//$dao->update($update);

var_dump($result);
