<?php

use RAR\Framework\Database\Data\DataContextFactory;
use Library\Services\ContactService;

class TestUnitCase extends UnitTestCase
{
	function testConnection()
	{
		$connection = DataContextFactory::GetConnection();
		$this->assertNotNull($connection);
	}

	function testInsertData()
	{
		$contact = Fixtures::newContactData();
		$contact = ContactService::create($contact);
		$this->assertNotNull($contact);
	}

	function testFindData()
	{
		$contact = Fixtures::createdContactData();
		$contact = ContactService::find($contact);
		$this->assertNotNull($contact);
	}

	function testUpdateData()
	{
		$contact       = Fixtures::createdContactData();
		$contact       = ContactService::find($contact);
		$contact->Name = "Alexandre de Souza";

		$this->assertEqual($contact->Name, "Alexandre de Souza");
	}

	function testDeleteData()
	{
		$contact = Fixtures::createdContactData();
		ContactService::remove($contact);
		$contact = ContactService::find($contact);
		$this->assertNull($contact);
	}
}
