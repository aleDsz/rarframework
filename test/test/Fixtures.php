<?php

use Library\Entities\Contact;

class Fixtures
{
	public static function ContactData()
	{
		$contact              = new Contact();
		$contact->Name        = "Joseph";
		$contact->Email       = uniqid() . "@aledsz.com.br";
		$contact->PhoneNumber = uniqid();

		return $contact;
	}
}
