<?php

namespace Library\Services;

use Library\Factories\DataAccessFactory;

/**
	 * Contacts's Service class
 */
class ContactService
{
	public static function create($obj)
	{
		$dao = DataAccessFactory::getContactDataAccessInstance();
		$dao->create($obj);
		return self::find($obj);
	}

	public static function save($obj)
	{
		$dao = DataAccessFactory::getContactDataAccessInstance();
		$dao->save($obj);
		return self::find($obj);
	}

	public static function find($obj)
	{
		$dao = DataAccessFactory::getContactDataAccessInstance();
		return $dao->find($obj);
	}

	public static function findAll($obj)
	{
		$dao = DataAccessFactory::getContactDataAccessInstance();
		return $dao->findAll($obj);
	}

	public static function remove($obj)
	{
		$dao = DataAccessFactory::getContactDataAccessInstance();
		$dao->remove($obj);
		return null;
	}
}
