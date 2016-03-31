<?php
function update_body_format($table, $old, $new) {
  // Get database connection
  \Drupal\Core\Database\Database::setActiveConnection();
  $connection = \Drupal\Core\Database\Database::getConnection();

  // Update the body_format for the specified table
  $results = $connection->update($table)
    ->fields(array(
        'body_format' => $new,
		))
	->condition('body_format', $old, '=')
	->execute();

  return $results;
}

$drush_args = drush_get_arguments();
$old_format = $drush_args[2];
$new_format = $drush_args[3];
$results = update_body_format('block_content__body', $old_format, $new_format);
print "Updated body_format for $results block(s) from $old_format to $new_format...\n";
$results = update_body_format('node__body', $old_format, $new_format);
print "Updated body_format for $results node(s) from $old_format to $new_format...\n";
?>