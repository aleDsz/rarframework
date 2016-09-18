<?php

namespace Library\Entities;

/**
 * @table contacts
 */
class Contact {
	public function __construct() {}

	/**
	 * @field id
	 * @type integer
	 * @pk True
	 * @size 11
	 */
	public $Id;

	/**
	 * @field name
	 * @type varchar
	 * @pk False
	 * @size 120
	 */
	public $Name;

	/**
	 * @field email
	 * @type varchar
	 * @pk True
	 * @size 120
	 */
	public $Email;

	/**
	 * @field phone
	 * @type varchar
	 * @pk False
	 * @size 30
	 */
	public $PhoneNumber;
}
