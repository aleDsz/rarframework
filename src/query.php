<?php

namespace rarframework {
  use rarframework\query\Query as QueryBuilder;
  
  class Query {
    private $builder;

    public function from(\rarframework\Schema $schema) {
      $this -> builder = new QueryBuilder($schema);
      return $this;
    }

    public function where(Array $conditions) {
      return $this;
    }

    public function build() {
      return $this -> builder;
    }
  }
}