<?php

require_once __DIR__ . "/dao/PlanqueDAO.php";
require_once __DIR__ . "/dao/DAOFactory.php";

DAOFactory::registerDAO(PlanqueDAO::class);
/**
 * @var PlanqueDAO $planqueDAO
 */
$planqueDAO = DAOFactory::getDAO(PlanqueDAO::class);
$result = $planqueDAO->getAll();
var_dump($result);
