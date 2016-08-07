<?php

namespace RAR\Framework\Database\Data;

use PDO;
use Exception;
use RAR\Framework\Database\Exceptions\RarFrameworkException;

/**
 * Fabricador da classe PDO para acessar aos drivers de banco de dados
 */
class DataContextFactory
{
	private static $Config = Array();

	public function __construct()
	{
	}

	private static function LoadConfig()
	{
		try
		{
			self::$Config = parse_ini_file("config.ini");
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public static function GetConnection()
	{
		self::LoadConfig();

		if (self::$Config == null)
			throw new Exception("Arquivo de configuração não encontrado: config.ini", 404);

		$host = self::$Config["host"];
		$port = self::$Config["port"];
		$user = self::$Config["user"];
		$pwd  = self::$Config["pwd"];
		$db   = self::$Config["db"];
		$type = self::$Config["type"];

		try
		{
			switch ($type)
			{
				case "mysql":
					$dsn = "mysql:host=$host:$port;dbname=$db";
					return new PDO($dsn, $user, $pwd);
					break;

				case "sqlite":
					$dsn = "sqlite:$host";
					return new PDO($dsn);
					break;

				case "pgsql":
					$dsn = "pgsql:host=$host;dbname=$db";
					return new PDO($dsn, $user, $pwd);
					break;

				case "db2":
					$dsn = "ibm:ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=$db;HOSTNAME=$host;PORT=$port;PROTOCOL=TCPIP;";
					return new PDO($dsn, $user, $pwd);
					break;

				case "sqlserver":
				case "mssql":
					$dsn = "dblib:host=$host:$port;dbname=$db";
					return new PDO($dsn, $user, $pwd);
					break;
				
				default:
					$dsn = "$type:host=$host;dbname=$db";
					return new PDO($dsn, $user, $pwd);
					break;
			}
		}
		catch (PDOException $e)
		{
			RarFrameworkException::LogError($e);
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}
}

?>