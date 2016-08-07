<?php

namespace RAR\Framework\Database\SQL\QueryBuilders;

/* Use */
use Exception;
use RAR\Framework\Database\SQL\QueryBuilders\QueryBuilder;
use RAR\Framework\Logging\Log\LogManager;

/**
 * Classe para manipulação de String SQL para a função UPDATE
 */
class UpdateQueryBuilder extends QueryBuilder
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

	public function GetSetClause()
	{
		try
		{
			$sql = null;
			$max = count($this->FieldList);

			for ($i = 0; $i < $max; $i++)
				$sql .= "{$this->FieldList[$i]} = " . ($this->ValueList[$i] == null ? "null" : $this->GetQuotedValue($this->ValueList[$i])) . ",\r\n       ";

			$sql = substr($sql, 0, strripos($sql, ",\r\n       "));

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
			$sql  = "UPDATE {$this->GetFromClause()}\r\n";
			$sql .= "   SET {$this->GetSetClause()}\r\n";
			$sql .= " WHERE {$this->GetWhereClause()}";

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