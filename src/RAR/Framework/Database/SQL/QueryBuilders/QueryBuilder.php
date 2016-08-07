<?php

namespace RAR\Framework\Database\SQL\QueryBuilders;

/* Use */
use Exception;

/**
 * Classe para manipulação de String SQL para a função SELECT
 */
class QueryBuilder
{
	protected $FieldList = Array();
	protected $FromList  = Array();
	protected $WhereList = Array();

	public function __construct()
	{
	}

	public function AddField($Field)
	{
		try
		{
			array_push($this->FieldList, $Field);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function AddFrom($From)
	{
		try
		{
			array_push($this->FromList, $From);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function AddWhere($Where)
	{
		try
		{
			array_push($this->WhereList, $Where);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function GetFieldClause()
	{
		try
		{
			$sql = null;

			foreach ($this->FieldList as $Field)
				$sql .= "$Field, ";

			$sql = substr($sql, 0, strripos($sql, ", "));

			return trim($sql);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function GetFromClause()
	{
		try
		{
			$sql = null;

			foreach ($this->FromList as $From)
				$sql .= "$From, ";

			$sql = substr($sql, 0, strripos($sql, ", "));

			return trim($sql);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function GetWhereClause()
	{
		try
		{
			$sql = null;

			foreach ($this->WhereList as $Where)
			{
				$sql .= "$Where\r\n   AND ";
			}

			$sql = substr($sql, 0, strripos($sql, "\r\n   AND "));

			return trim($sql);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function GetQuotedValue($Value)
	{
		if (is_string($Value))
			return "'$Value'";
		else
			return "$Value";
	}
}

?>