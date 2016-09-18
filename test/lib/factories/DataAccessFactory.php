<?php

namespace Library\Factories;

use Library\DataAccess\ContactDataAccess;

/**
 * DataAccess's Factory class
 */
class DataAccessFactory
{
	private static $contactDataAccess = null;

	public static function getContactDataAccessInstance()
	{
		if (self::$contactDataAccess == null)
			self::$contactDataAccess = new ContactDataAccess();
		return self::$contactDataAccess;
	}
}
