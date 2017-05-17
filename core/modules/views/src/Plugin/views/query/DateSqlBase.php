<?php

namespace Drupal\views\Plugin\views\query;

use Drupal\Core\Database\Connection;

/**
 * Common date SQL base class.
 */
abstract class DateSqlBase implements DateSqlInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Construct the date sql class.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

}
