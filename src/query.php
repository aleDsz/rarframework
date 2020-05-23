<?php

namespace rarframework {
  use rarframework\query\Query as QueryBuilder;
  
  class Query {
    private $_builder;

    public function from(\rarframework\Schema $schema) {
      $this -> _builder = new QueryBuilder($schema);
      return $this;
    }

    public function where(Array $conditions) {
      return $this;
    }

    public function build() {
      return $this -> _builder;
    }
  }
}