<?php

namespace rarframework\query {
  class Query {
    private $schema;
    private $where = [];
    private $joins = [];
    private $fields = [];
    private $order_by = [];
    private $group_by = [];
    private $limit;

    function __construct(\rarframework\Schema $schema) {
      $this -> schema = $schema;
    }

    public function getSchema() {
      return $this -> schema;
    }
  }
}