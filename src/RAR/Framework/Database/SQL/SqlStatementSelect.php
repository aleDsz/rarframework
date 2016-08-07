<?php

namespace RAR\Framework\Database\SQL;

/* Use */
use Exception;
use RAR\Framework\Database\Objects\Properties;
use RAR\Framework\Database\Objects\ObjectContext;
use RAR\Framework\Database\SQL\SqlStatement;
use RAR\Framework\Database\SQL\QueryBuilders\SelectQueryBuilder;
use RAR\Framework\Logging\Log\LogManager;
use RAR\Framework\Database\Enums\TiposSelect;
use RAR\Framework\Database\Exceptions\RarFrameworkException;

/**
 * Classe para manipulação de String SQL para a função SELECT
 */
class SqlStatementSelect extends SqlStatement
{
	private $Object = null;
	private $SSQL   = null;

	public function __construct($Obj)
	{
		$this->Object = $Obj;
	}

	private function CreateSQL($isList)
	{
		try
		{
			$Object        = $this->Object;
			$ObjectContext = new ObjectContext($Object);
			$ListProps     = $ObjectContext->GetProperties();

			if (!$isList)
			{
				$pks = 0;
				foreach ($ListProps as $Prop)
				{
					if ($Prop->Value != null)
					{
						if ($Prop->PrimaryKey == "True")
							$pks++;
					}
				}

				if ($pks == 0)
					throw new Exception("Informar pelo menos 1 Primary Key", 404);
			}

			$SelectQueryBuilder = new SelectQueryBuilder();
			$SelectQueryBuilder->AddFrom($ObjectContext->GetTableName());

			foreach ($ListProps as $Prop)
			{
				$SelectQueryBuilder->AddField($Prop->FieldName);

				if ($Prop->Value != null)
					$SelectQueryBuilder->AddWhere("{$Prop->FieldName} {$this->GetQuotedValue($Prop->Value, $Prop->Type)}");
			}

			$this->SSQL = $SelectQueryBuilder->ToString();
		}
		catch (Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function GetSQL($isList = false)
	{
		try
		{
			$this->CreateSQL($isList);
			return $this->SSQL;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}
}

?>