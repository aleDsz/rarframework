<?php

namespace RAR\Framework\Database\Data;

use PDO;
use RAR\Framework\Database\Data\DataContextFactory;
use RAR\Framework\Logging\Log\LogManager;

/**
 * Classe para acesso ao banco de dados
 * - Manipulação de transações
 * - Conexão
 * - Execução de instrução SQL
 */
class DataContext
{
	private $Connection = null;

	public function __construct()
	{
		try
		{
			$this->Connection = DataContextFactory::GetConnection();
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function Conectar()
	{
		try
		{
			$this->Connection = DataContextFactory::GetConnection();
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function Desconectar()
	{
		try
		{
			if (isset($this->Connection))
				$this->Connection = null;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function Begin()
	{
		try
		{
			$db = $this->Connection;
			
			if ($db == null)
			{
				$this->Conectar();
				$db = $this->Connection;
			}

			$db->beginTransaction();

			LogManager::LogTrace("Abertura de transação", __FUNCTION__);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function Commit()
	{
		try
		{
			$db = $this->Connection;
			
			if ($db == null)
				throw new Exception("Conexão não encontrada");

			$db->commit();

			LogManager::LogTrace("Finalização de transação", __FUNCTION__);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function Rollback()
	{
		try
		{
			$db = $this->Connection;
			
			if ($db == null)
				throw new Exception("Conexão não encontrada");

			$db->rollBack();

			LogManager::LogTrace("Descarte de transação", __FUNCTION__);
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public function ExecuteReader($sql)
	{
		$db = $this->Connection;
		try
		{
			if ($db == null)
			{
				$this->Conectar();
				$db = $this->Connection;
			}

			$stmt   = $db->prepare($sql);
			$stmt->execute();
			$count  = $stmt->rowCount();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			LogManager::LogTrace("$count registro(s) encontrado(s)", __FUNCTION__);

			return $result;
		}
		catch (Exception $e)
		{
			$db->rollBack();
			throw $e;
		}
	}

	public function ExecuteQuery($sql)
	{
		$db = $this->Connection;
		try
		{
			if ($db == null)
			{
				$this->Conectar();
				$db = $this->Connection;
			}

			$stmt  = $db->prepare($sql);
			$stmt->execute();
			$count = $stmt->rowCount();

			LogManager::LogTrace("$count registro(s) afetado(s)", __FUNCTION__);
		}
		catch (Exception $e)
		{
			$db->rollBack();
			throw $e;
		}
	}
}

?>