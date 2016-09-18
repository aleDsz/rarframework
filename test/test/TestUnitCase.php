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
		$contact = Fixtures::ContactData();
		$contact = ContactService::create($contact);
		$this->assertNotNull($contact);
	}
}
