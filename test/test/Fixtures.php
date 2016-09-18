<?php

use Library\Entities\Contact;

class Fixtures
{
	public static $contactEmail = null;

	public static function newContactData()
	{
		$contact              = new Contact();
		$contact->Name        = "Joseph";
		$contact->Email       = uniqid() . "@aledsz.com.br";
		$contact->PhoneNumber = uniqid();
		self::$contactEmail   = $contact->Email;

		return $contact;
	}

	public static function createdContactData()
	{
		$contact        = new Contact();
		$contact->Email = self::$contactEmail;

		return $contact;
	}
}
