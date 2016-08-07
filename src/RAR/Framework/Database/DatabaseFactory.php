<?php

namespace RAR\Framework\Database;

use RAR\Framework\Database\Data\DataContext;

/**
 * Fabricador de instâncias de Database
 */
class DatabaseFactory
{
	private static $InstaceOfDataContext = null;

	public static function InstaceOfDataContext()
	{
		try
		{
			if (self::$InstaceOfDataContext == null)
				$InstaceOfDataContext = new DataContext();

			return $InstaceOfDataContext;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
}

?>