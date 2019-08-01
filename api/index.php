<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
require_once '../controller.php';
$controller = new Controller();
header('Content-type: application/json');
echo $controller->mountDaysJson($_GET["y"],$_GET["m"]);
?>