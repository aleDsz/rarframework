<?php

namespace rarframework {
  use rarframework\query\Query as QueryBuilder;
  
  class Schema {
    private $primary_key;
    private $table;
    private $relationships;

    function __construct(Array $data = []) {
      foreach ($data as $key => $value) {
        $this -> {$key} = $value;
      }
    }
  }
}