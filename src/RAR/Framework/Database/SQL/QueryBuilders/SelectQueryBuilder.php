<?php

namespace RAR\Framework\Database\SQL\QueryBuilders;

/* Use */
use Exception;
use RAR\Framework\Database\SQL\QueryBuilders\QueryBuilder;
use RAR\Framework\Logging\Log\LogManager;

/**
 * Classe para manipulação de String SQL para a função SELECT
 */
class SelectQueryBuilder extends QueryBuilder
{
	public function __construct()
	{
	}

	public function ToString()
	{
		try
		{
			$sql      = null;

			if (count($this->FieldList) > 0)
				$sql  = "SELECT {$this->GetFieldClause()}\r\n";
			else
				$sql  = "SELECT *";

			if (count($this->FromList) > 0)
				$sql .= "  FROM {$this->GetFromClause()}\r\n";

			if (count($this->WhereList) > 0)
				$sql .= " WHERE {$this->GetWhereClause()}\r\n";

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