<?php

namespace RAR\Framework\Database\SQL;

/* Use */
use Exception;
use RAR\Framework\Database\Objects\Properties;
use RAR\Framework\Database\Objects\ObjectContext;
use RAR\Framework\Database\SQL\SqlStatement;
use RAR\Framework\Database\SQL\QueryBuilders\DeleteQueryBuilder;
use RAR\Framework\Logging\Log\LogManager;
use RAR\Framework\Database\Enums\TiposSelect;
use RAR\Framework\Database\Exceptions\RarFrameworkException;

/**
 * Classe para manipulação de String SQL para a função DELETE
 */
class SqlStatementDelete extends SqlStatement
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
			$DeleteQueryBuilder = new DeleteQueryBuilder();
			$DeleteQueryBuilder->AddFrom($ObjectContext->GetTableName());

			foreach ($ListProps as $Prop)
				if ($Prop->PrimaryKey == "True")
					array_push($ListPks, $Prop);

			if (count($ListPks) == 0)
				throw new Exception("Informar pelo menos 1 Primary Key", 404);

			foreach ($ListPks as $Prop)
				$DeleteQueryBuilder->AddWhere("{$Prop->FieldName} {$this->GetQuotedValue($Prop->Value, $Prop->Type)}");

			$this->SSQL = $DeleteQueryBuilder->ToString();
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