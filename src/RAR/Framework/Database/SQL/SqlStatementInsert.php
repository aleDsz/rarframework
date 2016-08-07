<?php

namespace RAR\Framework\Database\SQL;

/* Use */
use Exception;
use RAR\Framework\Database\Objects\Properties;
use RAR\Framework\Database\Objects\ObjectContext;
use RAR\Framework\Database\SQL\SqlStatement;
use RAR\Framework\Database\SQL\QueryBuilders\InsertQueryBuilder;
use RAR\Framework\Logging\Log\LogManager;
use RAR\Framework\Database\Enums\TiposSelect;
use RAR\Framework\Database\Exceptions\RarFrameworkException;

/**
 * Classe para manipulação de String SQL para a função INSERT
 */
class SqlStatementInsert extends SqlStatement
{
	private $Object = null;
	private $SSQL   = null;

	public function __construct($Obj)
	{
		$this->Object = $Obj;
	}

	private function CreateSQL()
	{
		try
		{
			$Object             = $this->Object;
			$ObjectContext      = new ObjectContext($Object);
			$ListProps          = $ObjectContext->GetProperties();
			$InsertQueryBuilder = new InsertQueryBuilder();
			$InsertQueryBuilder->AddFrom($ObjectContext->GetTableName());

			foreach ($ListProps as $Prop)
			{
				$InsertQueryBuilder->AddField($Prop->FieldName);
				$InsertQueryBuilder->AddValue($Prop->Value);
			}

			$this->SSQL = $InsertQueryBuilder->ToString();
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function GetSQL()
	{
		try
		{
			$this->CreateSQL();
			return $this->SSQL;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}
}

?>