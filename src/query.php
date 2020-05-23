<?php

namespace rarframework {
  use rarframework\query\Query as QueryBuilder;
  
  class Query {
    private $_builder;

    public function from(\rarframework\Schema $schema) {
      $this -> _builder = new QueryBuilder($schema);
      return $this;
    }

    public function where($conditions) {
      if (\is_string($conditions)) {
        $this -> _builder -> setWhere($conditions);
        return $this;
      } else {
        throw new \Exception("Received argument isn't a string");
      }
    }

    public function build() {
      return $this -> _builder;
    }
  }
}