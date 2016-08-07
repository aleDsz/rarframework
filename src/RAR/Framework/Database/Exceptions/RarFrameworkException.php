<?php

namespace RAR\Framework\Database\Exceptions;

use Exception;
use RAR\Framework\Logging\Log\LogManager;

/**
 * Classe para realizar a documentação das exceções que ocorrem na Framework
 */
class RarFrameworkException extends Exception
{
	public static function LogError(Exception $e)
	{
		// echo "Ocorreu um erro, favor reportar ao Departamento de Informática!\r\nErro: {$e->getMessage()}";

		$mensagemToLog = "Ocorreu um erro na linha " . $e->getLine() . " no arquivo " . $e->getFile() . "\r\n";

		foreach ($e->getTrace() as $key => $value)
			$mensagemToLog .= "Ocorreu uma exception na linha " . $value["line"] . " na classe " . $value["class"] . " na função " . $value["function"] . "\r\n";

		LogManager::LogError($e->getMessage(), (count($e->getTrace()) > 0 ? $e->getTrace()[0]["function"] : "NON-FUNCTION"), $mensagemToLog);
		die;
	}
}

?>
