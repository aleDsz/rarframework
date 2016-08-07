<?php

namespace RAR\Framework\Database\SQL;

/* Use */
use Exception;
use RAR\Framework\Database\Objects\Properties;
use RAR\Framework\Database\Objects\ObjectContext;
use RAR\Framework\Database\SQL\SqlStatement;
use RAR\Framework\Database\SQL\QueryBuilders\UpdateQueryBuilder;
use RAR\Framework\Logging\Log\LogManager;
use RAR\Framework\Database\Enums\TiposSelect;
use RAR\Framework\Database\Exceptions\RarFrameworkException;

/**
 * Classe para manipulação de String SQL para a função UPDATE
 */
class SqlStatementUpdate extends SqlStatement
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
			$ListPks            = Array();
			$ListNoPks          = Array();
			$UpdateQueryBuilder = new UpdateQueryBuilder();
			$UpdateQueryBuilder->AddFrom($ObjectContext->GetTableName());

			foreach ($ListProps as $Prop)
			{
				if ($Prop->PrimaryKey == "True")
					array_push($ListPks, $Prop);
				else
					array_push($ListNoPks, $Prop);
			}

			if (count($ListPks) == 0)
				throw new Exception("Informar pelo menos 1 Primary Key", 404);

			foreach ($ListNoPks as $Prop)
			{
				$UpdateQueryBuilder->AddField($Prop->FieldName);
				$UpdateQueryBuilder->AddValue($Prop->Value);
			}

			foreach ($ListPks as $Prop)
				$UpdateQueryBuilder->AddWhere("{$Prop->FieldName} {$this->GetQuotedValue($Prop->Value, $Prop->Type)}");

			$this->SSQL = $UpdateQueryBuilder->ToString();
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