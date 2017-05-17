<?php

namespace Drupal\views\Plugin\views\query;

/**
 * MySQL-specific date handling.
 */
class MysqlDateSql extends DateSqlBase {

  /**
   * An array of PHP-to-MySQL replacement patterns.
   */
  protected static $replace = [
    'Y' => '%Y',
    'y' => '%y',
    'M' => '%b',
    'm' => '%m',
    'n' => '%c',
    'F' => '%M',
    'D' => '%a',
    'd' => '%d',
    'l' => '%W',
    'j' => '%e',
    'W' => '%v',
    'H' => '%H',
    'h' => '%h',
    'i' => '%i',
    's' => '%s',
    'A' => '%p',
  ];

  /**
   * {@inheritdoc}
   */
  public function getDateField($field, $string_date) {
    if ($string_date) {
      return $field;
    }
    return "DATE_ADD('19700101', INTERVAL $field SECOND)";
  }

  /**
   * {@inheritdoc}
   */
  public function getDateFormat($field, $format) {
    $format = strtr($format, static::$replace);
    return "DATE_FORMAT($field, '$format')";
  }

  /**
   * {@inheritdoc}
   */
  public function setTimezoneOffset($offset) {
    $this->database->query("SET @@session.time_zone = '$offset'");
  }

  /**
   * {@inheritdoc}
   */
  public function setFieldTimezoneOffset(&$field, $offset) {
    if (!empty($offset)) {
      $field = "($field + INTERVAL $offset SECOND)";
    }
  }

}
