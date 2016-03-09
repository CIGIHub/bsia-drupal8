<?php
/**
 * Perform an SQL query and return success or failure.
 *
 * @see http://api.drupal.org/api/function/update_sql/6
 *
 * @param $sql
 *   A string containing a complete SQL query.
 * @return
 *   An array containing the keys:
 *      success: a boolean indicating whether the query succeeded
 *      query: the SQL query executed, passed through check_plain()
 *      rows: number of rows effected
 */
function my_update_sql($sql) {
  $args = func_get_args();
  array_shift($args);
  $result = db_query($sql, $args);
  $sql = my_return_query_string($sql, $args);
  return array('success' => $result !== FALSE, 'query' => check_plain($sql), 'rows' => db_affected_rows());
}

/**
 * Builds a basic query, returns string.
 *
 * @see http://api.drupal.org/api/function/db_query/6
 *
 * @param $query
 *   A string containing an SQL query.
 * @param ...
 *   A variable number of arguments which are substituted into the query
 *   using printf() syntax. Instead of a variable number of query arguments,
 *   you may also pass a single array containing the query arguments.
 *
 *   Valid %-modifiers are: %s, %d, %f, %b (binary data, do not enclose
 *   in '') and %%.
 *
 *   NOTE: using this syntax will cast NULL and FALSE values to decimal 0,
 *   and TRUE values to decimal 1.
 *
 * @return
 *   String of query that would have been run
 */
function my_return_query_string($query) {
  $args = func_get_args();
  array_shift($args);
  $query = db_prefix_tables($query);
  if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
    $args = $args[0];
  }
  _db_query_callback($args, TRUE);
  $query = preg_replace_callback(DB_QUERY_REGEXP, '_db_query_callback', $query);
  return $query;
}

$drush_args = drush_get_arguments();
$lang_code = $drush_args[2];
$sql = my_return_query_string("UPDATE url_alias SET language = '%s' WHERE language <> '%s'", $lang_code, $lang_code);
$result = my_update_sql($sql);
var_dump($result);
?>