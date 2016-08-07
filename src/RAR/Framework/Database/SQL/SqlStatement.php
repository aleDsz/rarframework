<?php

namespace RAR\Framework\Database\SQL;

/* Use */
use Exception;
use RAR\Framework\Database\Data\DataContext;

/**
 * Classe para manipulação de String SQL com métodos comuns
 * - Obter valores das propriedades pra utilizar no SQL
 */
class SqlStatement
{
	public function __construct()
	{
	}

	public function GetQuotedValue($PropValue, $Type)
	{
		try
		{
			$sqlValue = null;

			if ($PropValue != null && $Type != null)
			{
				switch (strtolower($Type))
				{
					case "integer":
					case "smallint":
					case "bigint":
					case "mediumint":
					case "currency":
					case "money":
					case "float":
					case "double":
					case "decimal":
					case "bit":
					case "tinyint":
						if (is_array($PropValue))
						{
							$sqlValue = "IN (";
							foreach ($PropValue as $value)
								$sqlValue .= "$value, ";
							$sqlValue = substr($sqlValue, 0, strripos($sqlValue, ", "));
							$sqlValue = ")";
						}
						else
							$sqlValue = "= {$PropValue}";
						break;
					
					default:
						if ($this->startsWith($PropValue, "%") || $this->endsWith($PropValue, "%"))
							$sqlValue = "LIKE '{$PropValue}'";
						else
							if (is_array($PropValue))
							{
								$sqlValue = "IN (";
								foreach ($PropValue as $value)
									$sqlValue .= "'$value', ";
								$sqlValue = substr($sqlValue, 0, strripos($sqlValue, ", "));
								$sqlValue = ")";
							}
							else
								$sqlValue = "= '{$PropValue}'";
						break;
				}
			}

			return $sqlValue;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	private function startsWith($String, $Search)
	{
		try
		{
			return $Search === "" || strrpos($String, $Search, -strlen($String)) !== false;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	private function endsWith($String, $Search)
	{
		try
		{
			return $Search === "" || (($temp = strlen($String) - strlen($Search)) >= 0 && strpos($String, $Search, $temp) !== false);
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}
}
?>
