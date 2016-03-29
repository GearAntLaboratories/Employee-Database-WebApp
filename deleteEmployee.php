<?php

require_once("Includes/db.php");
EmployeeDB::getInstance()->delete_employee($_POST["empID"]);

header('Location: empSearch.php')
?>

