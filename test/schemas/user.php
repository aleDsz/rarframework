<?php

namespace tests\schemas {
  class User extends \rarframework\Schema {

    /**
     * @primary_key id, uuid, autogenerate: true
     * @schema users
     * @field name, string, not_null
     * @field email, string, default: test@test.com
     * @field age, integer
     */
    function __construct() {
      parent::__construct();
    }
  }
}