<?php

namespace rarframework\schema {
  use Ramsey\Uuid\Uuid;

  class Parser {
    protected const REGEX_COMMENTARY = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";
    protected const REGEX_ANNOTATION = "#(\@([^\s]+)\s(.*))#";
    protected const REGEX_DEFAULT = '/^(.*:)+\s+(.*)/i';

    public function parseAnnotations($commentaries = "") {
      preg_match_all(
        self::REGEX_COMMENTARY,
        $commentaries,
        $annotations,
        PREG_PATTERN_ORDER
      );

      $items = [];

      foreach ($annotations[0] as $annotation) {
        $annotation = $this -> parseAnnotation($annotation);
        $key = array_key_first($annotation);

        if (isset($items[$key])) {
          $items[$key][] = $annotation[$key];
        } else {
          $items[$key] = [$annotation[$key]];
        }
      }

      return $items;
    }

    public function parseAnnotation($annotation) {
      preg_match_all(
        self::REGEX_ANNOTATION,
        $annotation,
        $items,
        PREG_PATTERN_ORDER
      );

      $action = $items[2][0];
      $parameters = $items[3][0];
      $parameters = explode(",", $parameters);

      if ($action !== "schema" && \count($parameters) < 2) {
        throw new \Exception("Annotation parameters must be at least 2 arguments");
      }

      switch ($action) {
        case "primary_key": return $this -> parsePrimaryKey($parameters);
        case "schema": return $this -> parseSchema($parameters);
        case "field": return $this -> parseField($parameters);

        default: return [];
      }
    }

    public function parseField($parameters) {
      $field_name = \trim($parameters[0]);
      $type = \trim($parameters[1]);

      $options = [
        "default" => null,
        "null" => true
      ];

      unset($parameters[0]);
      unset($parameters[1]);
      array_values($parameters);

      $options = $this -> getOptions($type, $parameters);

      return [
        "field" => [
          "name" => $field_name,
          "type" => $type,
          "options" => $options
        ]
      ];
    }

    public function parseSchema($parameters) {
      return [
        "schema" => $parameters[0]
      ];
    }

    public function parsePrimaryKey($parameters) {
      $field_name = \trim($parameters[0]);
      $type = \trim($parameters[1]);

      $options = [];

      unset($parameters[0]);
      unset($parameters[1]);
      array_values($parameters);

      $options = $this -> getPrimaryKeyOptions($type, $parameters);

      return [
        "primary_key" => [
          "name" => $field_name,
          "type" => $type,
          "options" => $options
        ]
      ];
    }

    public function getOptions($type, $parameters) {
      $options = [];

      foreach ($parameters as $parameter) {
        $parameter = \trim($parameter);

        switch ($parameter) {
          case "not_null":
            $options["null"] = false;
            break;

          default:
            preg_match_all(
              self::REGEX_DEFAULT,
              $parameter,
              $value,
              PREG_PATTERN_ORDER
            );

            if (count($value[1]) > 0) {
              $key = $value[1][0];
              $value = $value[2][0];

              if ($key === "default:") {
                $options["default"] = $this -> getDefaultValue($type, $value);
              }
            }

            break;
        }
      }

      return $options;
    }

    public function getPrimaryKeyOptions($type, $parameters) {
      $options = [];

      foreach ($parameters as $parameter) {
        $parameter = \trim($parameter);

        preg_match_all(
          self::REGEX_DEFAULT,
          $parameter,
          $value,
          PREG_PATTERN_ORDER
        );

        if (count($value[1]) > 0) {
          $key = $value[1][0];
          $value = $value[2][0];

          if ($key === "autogenerate:") {
            if ($value === "true") {
              $options["default"] = $this -> getDefault($type);
            }
          }
        }
      }

      return $options;
    }

    public function getDefault($type) {
      switch ($type) {
        case "object":
        case "json":
          return \json_decode("{}");

        case "integer":
          return 0;

        case "boolean":
          return false;

        case "uuid":
          return Uuid::uuid4() -> toString();

        case "binary_id":
          return Uuid::uuid4() -> getBytes();

        default:
          return "";
      }
    }

    public function getDefaultValue($type, $value) {
      switch ($type) {
        case "object":
        case "json":
          return \json_decode($value);

        case "integer":
          return (int) $value;

        case "boolean":
          return (bool) $value;

        case "binary_id":
          return Uuid::fromBytes($value);

        default:
          return $value;
      }
    }
  }
}