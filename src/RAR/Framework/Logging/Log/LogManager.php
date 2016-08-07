<?php

namespace RAR\Framework\Logging\Log;

class LogManager
{
	public static $LogFile = "XpressApp.txt";

	public function __construct()
	{
	}

	public static function LogTrace($mensagem, $origem)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date("d/m/Y");
		$hora = date("H:i:s.u");
		if (is_array($mensagem))
		{
			$msg = "";
			foreach ($mensagem as $ch => $valor) {
				foreach ($valor as $key => $value) {
					$msg .= "$key = '$value'\r\n";
				}
			}
			$msg = trim($msg);
			$texto = "[$data $hora] [" . @debug_backtrace()[1]["class"] . "::$origem] [TRACE] - $msg\r\n";
		}
		else
			$texto = "[$data $hora] [" . @debug_backtrace()[1]["class"] . "::$origem] [TRACE] - $mensagem\r\n";
		
		$manipular = fopen(self::$LogFile, "a+b");
		fwrite($manipular, $texto);
		fclose($manipular);
	}

	public static function LogError($mensagem, $origem, $ex)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date("d/m/Y");
		$hora = date("H:i:s.u");
		if (is_array($mensagem))
		{
			$msg = "";
			foreach ($mensagem as $ch => $valor) {
				foreach ($valor as $key => $value) {
					$msg .= "$key = '$value'\r\n";
				}
			}
			$msg = trim($msg);
			$texto = "[$data $hora] [" . @debug_backtrace()[1]["class"] . "::$origem] [ERROR] - $msg\r\n$ex\r\n";
		}
		else
			$texto = "[$data $hora] [" . @debug_backtrace()[1]["class"] . "::$origem] [ERROR] - $mensagem\r\n$ex\r\n";

		$manipular = fopen(self::$LogFile, "a+b");
		fwrite($manipular, $texto);
		fclose($manipular);
	}
}

?>