<?php

$URL = dirname(__FILE__);

/* Header */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, HEAD");
@header("Access-Control-Allow-Headers: Content-type, {$_SERVER['HTTP_ACCESS_CONTROL_ALLOW_HEADERS']}");
header("Access-Control-Max-Age: 1728000");

/* Requires */

/* Log */
require_once("$URL/Framework/Logging/Log/LogManager.php");

/* Exceptions */
require_once("$URL/Framework/Database/Exceptions/RarFrameworkException.php");

/* Objects */
require_once("$URL/Framework/Database/Objects/ObjectContext.php");
require_once("$URL/Framework/Database/Objects/Properties.php");

/* SqlStatement */
require_once("$URL/Framework/Database/SQL/SqlStatement.php");
require_once("$URL/Framework/Database/SQL/SqlStatementSelect.php");
require_once("$URL/Framework/Database/SQL/SqlStatementInsert.php");
require_once("$URL/Framework/Database/SQL/SqlStatementUpdate.php");
require_once("$URL/Framework/Database/SQL/SqlStatementDelete.php");

/* QueryBuilders */
require_once("$URL/Framework/Database/SQL/QueryBuilders/QueryBuilder.php");
require_once("$URL/Framework/Database/SQL/QueryBuilders/SelectQueryBuilder.php");
require_once("$URL/Framework/Database/SQL/QueryBuilders/InsertQueryBuilder.php");
require_once("$URL/Framework/Database/SQL/QueryBuilders/UpdateQueryBuilder.php");
require_once("$URL/Framework/Database/SQL/QueryBuilders/DeleteQueryBuilder.php");

/* Enums */
require_once("$URL/Framework/Database/Enums/TiposSelect.php");

/* Factory */
require_once("$URL/Framework/Database/DatabaseFactory.php");

/* Data */
require_once("$URL/Framework/Database/Data/DataContext.php");
require_once("$URL/Framework/Database/Data/DataContextFactory.php");

/* Command */
require_once("$URL/Framework/Database/Command/CommandContext.php");


?>
