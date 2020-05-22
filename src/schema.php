<?php

namespace rarframework {
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