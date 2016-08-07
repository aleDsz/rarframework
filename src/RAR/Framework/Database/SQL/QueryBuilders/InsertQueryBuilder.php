<?php

namespace RAR\Framework\Database\SQL\QueryBuilders;

/* Use */
use Exception;
use RAR\Framework\Database\SQL\QueryBuilders\QueryBuilder;
use RAR\Framework\Logging\Log\LogManager;

/**
 * Classe para manipulação de String SQL para a função SELECT
 */
class InsertQueryBuilder extends QueryBuilder
{
	private $ValueList = Array();

	public function __construct()
	{
	}

	public function AddValue($Value)
	{
		try
		{
			array_push($this->ValueList, $Value);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function GetValueClause()
	{
		try
		{
			$sql = null;

			foreach ($this->ValueList as $Value)
				$sql .= ($Value == null ? "null" : $this->GetQuotedValue($Value)) . ", ";

			$sql = substr($sql, 0, strripos($sql, ", "));

			return trim($sql);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function ToString()
	{
		try
		{
			$sql  = "INSERT INTO {$this->GetFromClause()} ";
			$sql .= "({$this->GetFieldClause()})";
			$sql .= " VALUES ";
			$sql .= "({$this->GetValueClause()})";

			LogManager::LogTrace("SQL: \r\n" . trim($sql), __FUNCTION__);

			return trim($sql);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
}

?>