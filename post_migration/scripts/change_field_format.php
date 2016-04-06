<?php
function update_field_format($field_name, $new) {
  // Get database connection
  \Drupal\Core\Database\Database::setActiveConnection();
  $connection = \Drupal\Core\Database\Database::getConnection();

  $table = 'node__field_' . $field_name;
  $format_column = 'field_' . $field_name . '_format';

  // Update the format for the specified table
  $results = $connection->update($table)
    ->fields(array(
        $format_column => $new,
		))
	->execute();

  return $results;
}

$drush_args = drush_get_arguments();
$field_name = $drush_args[2];
$new_format = $drush_args[3];
$results = update_field_format($field_name, $new_format);
print "Updated format for $results $field_name row(s) to $new_format...\n";
?>