<?php
require_once("./database.php");

try {
    $DB = new Database("admin", "E.F.Codd");
} catch (PDOException $error) {
    print_r($error);
}
