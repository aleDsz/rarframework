<?php

namespace RAR\Framework\Database\Command;

use PDO;
use RAR\Framework\Logging\Log\LogManager;
use RAR\Framework\Database\DatabaseFactory;
use RAR\Framework\Database\Exceptions\RarFrameworkException;

/**
 * Classe para execução de instruções SQL
 */
class CommandContext
{
	private $Command     = null;
	private $DataContext = null;

	public function __construct($SSQL)
	{
		$this->Initialize($SSQL);
	}

	private function Initialize($SSQL)
	{
		try
		{
			$this->DataContext = DatabaseFactory::InstaceOfDataContext();
			$this->Command     = $SSQL;
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function SetSql($SSQL)
	{
		try
		{
			$this->Command = $SSQL;
			LogManager::LogTrace("Executando SQL: \r\n$SSQL", __FUNCTION__);
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function ExecuteQuery()
	{
		try
		{
			$this->DataContext->ExecuteQuery($this->Command);
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function ExecuteReader()
	{
		try
		{
			return $this->DataContext->ExecuteReader($this->Command);
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}
}
?>