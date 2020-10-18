<?php

require_once __DIR__ . "/dao/SpecialiteDAO.php";
require_once __DIR__ . "/dao/DAOFactory.php";

DAOFactory::registerDAO(SpecialiteDAO::class);
/**
 * @var SpecialiteDAO $dao
 */
$dao = DAOFactory::getDAO(SpecialiteDAO::class);
$result = $dao->getAll();

// UPDATE
//$update = $result[0];
//$update->setLibelle($update->getLibelle() . " test");
//$dao->update($update);

var_dump($result);
