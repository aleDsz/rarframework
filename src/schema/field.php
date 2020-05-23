<?php

namespace rarframework\schema {
  class Field {
    public $name;
    public $type;
    public $null = true;
    public $default = null;

    function __construct($data) {
      foreach ($data as $key => $value) {
        $this -> {$key} = $value;
      }
    }
  }
}