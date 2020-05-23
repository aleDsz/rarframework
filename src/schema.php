<?php

namespace rarframework {
  class Schema {
    private $_parser;
    private $primary_key;
    private $table;
    private $relationships;
    private $fields;

    function __construct() {
      $this -> _parser = new \rarframework\Schema\Parser();
      $this -> bootstrap();
      $this -> inject();
    }

    private function bootstrap() {
      try {
        $reflection = new \ReflectionClass($this);
        $this -> fields = [];

        $constructor = $reflection -> getConstructor();

        if (!is_null($constructor)) {
          $commentaries = $constructor -> getDocComment();
          $metadata = $this -> _parser -> parseAnnotations($commentaries);
          
          $this -> table = $this -> initTable($metadata["schema"]);
          $this -> primary_key = $this -> newField($metadata["primary_key"][0]);
          $this -> fields = $this -> newFields($metadata["field"]);
        }
      } catch (\Exception $ex) {
        throw $ex;
      }
    }

    private function initTable($table) {
      return $table[0];
    }

    private function newField($data) {
      foreach ($data["options"] as $key => $value) {
        $data[$key] = $value;
      }

      unset($data["options"]);

      return new \rarframework\Schema\Field($data);
    }

    private function newFields($parameters) {
      $data = [];

      foreach ($parameters as $item) {
        $data[] = $this -> newField($item);
      }

      return $data;
    }

    private function inject() {
      try {
        $reflection = new \ReflectionClass($this);

        foreach ($this -> fields as $field) {
          $this -> {$field -> name} = $field -> default;
        }

        $this -> {$this -> primary_key -> name} = $this -> primary_key -> default;
      } catch (\Exception $ex) {
        throw $ex;
      }
    }
  }
}