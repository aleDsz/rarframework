<?php

namespace tests\rarframework;

use PHPUnit\Framework\TestCase;
use rarframework\Query;

class QueryTest extends TestCase {
  public function testFrom() {
    $schema = \tests\helpers\SchemaFixtures::newUser();

    $query = (new Query()) -> from ($schema);
    $builder = $query -> build();

    $this -> assertEquals($schema, $builder -> getSchema());
  }
}