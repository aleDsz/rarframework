<?php

namespace RAR\Framework\Database\Objects;

/* Use */
use Exception;
use ReflectionClass;
use ReflectionProperty;
use RAR\Framework\Database\Objects\Properties;
use RAR\Framework\Logging\Log\LogManager;
use RAR\Framework\Database\Exceptions\RarFrameworkException;

/**
 * Classe para manipulação de objetos
 * - Obter propriedades
 * - Obter valores
 * - Obter objeto(s) populados
 */
class ObjectContext
{
	private $Object  = null;
	private $Pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";

	public function __construct($Obj)
	{
		$this->Object = $Obj;
	}

	public function GetProperties()
	{
		try
		{
			$Reflection = new ReflectionClass($this->Object);
			$ListProps  = Array();
			$i          = 0;
			$Props      = $Reflection->getProperties(ReflectionProperty::IS_PUBLIC);

			foreach ($Props as $Prop)
			{
				$ListProps[$i] = $this->GetCustomAttributes($Prop);
				$i++;
			}

			return $ListProps;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function GetObject(Array $DataReader)
	{
		try
		{
			$Reflection = new ReflectionClass($this->Object);
			$Objeto     = null;
			$Props      = $this->GetProperties();

			if ($DataReader != null && count($DataReader) > 0)
			{
				$Objeto = $Reflection->newInstance();
				foreach ($Props as $Prop)
				{
					if ($Prop != null)
					{
						$Reflection->getProperty($Prop->PropName)->setValue($Objeto, $DataReader[0][$Prop->FieldName]);
						LogManager::LogTrace("Inserindo valor na propriedade [" . get_class($this->Object) . "->{$Prop->PropName}]: '{$DataReader[0][$Prop->FieldName]}'", __FUNCTION__);
					}
				}
			}

			return $Objeto;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function GetObjects(Array $DataReader)
	{
		try
		{
			$Reflection = new ReflectionClass($this->Object);
			$Objects    = Array();
			$Props      = $this->GetProperties();

			if ($DataReader != null)
			{
				$i      = 0;
				foreach ($DataReader as $Reader)
				{
					$Objeto = $Reflection->newInstance();
					foreach ($Props as $Prop)
					{
						if ($Prop != null)
						{
							$Reflection->getProperty($Prop->PropName)->setValue($Objeto, $Reader[$Prop->FieldName]);
							LogManager::LogTrace("Inserindo valor na propriedade [" . get_class($Objeto) . "->{$Prop->PropName}]: '{$Reader[$Prop->FieldName]}'", __FUNCTION__);
						}
					}
					$Objects[$i] = $Objeto;
					$i++;
				}

			}

			return $Objects;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	private function GetCustomAttributes(ReflectionProperty $Prop)
	{
		try
		{
			$Reflection = new ReflectionClass($this->Object);
			$Properties = null;

			if ($Prop != null)
			{
				$Comment    = $Reflection->getProperty($Prop->getName())->getDocComment();
				$Properties = new Properties();

				LogManager::LogTrace("Obtendo Annotation da Propriedade [" . get_class($this->Object) . "->{$Prop->getName()}]", __FUNCTION__);
				preg_match_all($this->Pattern, $Comment, $Annotations, PREG_PATTERN_ORDER);
				$Annotation = $Annotations[0];

				$Properties->SetValues($Prop->getName(),
					                   $this->GetAnnotation($Annotation[0]),
					                   $this->GetAnnotation($Annotation[1]),
					                   $this->GetAnnotation($Annotation[2]), 
					                   $this->GetAnnotation($Annotation[3]),
					                   $Reflection->getProperty($Prop->getName())->getValue($this->Object));
				LogManager::LogTrace("Inserindo valores na classe Properties para a Propriedade: " . get_class($this->Object) . "->{$Prop->getName()}", __FUNCTION__);
			}

			return $Properties;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function GetTableName()
	{
		try
		{
			$Reflection = new ReflectionClass($this->Object);
			$TableName  = null;

			if ($Reflection != null)
			{
				$Comment   = $Reflection->getDocComment();

				preg_match_all($this->Pattern, $Comment, $Annotations, PREG_PATTERN_ORDER);
				$TableName = $this->GetAnnotation($Annotations[0][0]);
				LogManager::LogTrace("Obtendo tabela da classe [" . get_class($this->Object) . "]: '$TableName'", __FUNCTION__);
			}

			return $TableName;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	private function GetAnnotation($Annotation)
	{
		try
		{
			return trim(explode(" ", $Annotation)[1]);
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}

	public function FillObject($POST)
	{
		try
		{
			$Reflection = new ReflectionClass($this->Object);

			foreach($POST as $FieldName => $Value)
			{
				$Reflection->getProperty($FieldName)->setValue($this->Object, $Value);
				LogManager::LogTrace("Preenchendo objeto [" . get_class($this->Object) . "->$FieldName]: '$Value'", __FUNCTION__);
			}

			return $this->Object;
		}
		catch(Exception $e)
		{
			RarFrameworkException::LogError($e);
		}
	}
}

?>