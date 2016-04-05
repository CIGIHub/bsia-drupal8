<?php
function strip_html_tags_from_field($field_name) {
    \Drupal\Core\Database\Database::setActiveConnection();
    $connection = \Drupal\Core\Database\Database::getConnection();

    $column_name = 'field_' . $field_name . '_value';
    $table_name = 'node__field_' . $field_name;
    $select_query = 'SELECT bundle, entity_id, revision_id, ' . $column_name . ' FROM ' . $table_name . ';';

    print "Updating value for " . $column_name . "...\n";
    $results = $connection->query($select_query)->fetchAll();
    $i = 0;
    if ($results) {
        foreach ($results as $record) {
            $new_value = strip_tags($record->$column_name);
            $connection->update($table_name)
                ->fields(array(
                    $column_name => $new_value,
                    ))
                ->condition('bundle', $record->bundle, '=')
                ->condition('revision_id', $record->revision_id, '=')
                ->condition('entity_id', $record->entity_id, '=')
                ->execute();
            $i = $i + 1;
        }
    }
    print "Updated " . $i . " row(s)\n";
}

strip_html_tags_from_field("feature_line");
strip_html_tags_from_field("quote");
strip_html_tags_from_field("research_focus");
strip_html_tags_from_field("short_bio");
strip_html_tags_from_field("short_description");
strip_html_tags_from_field("testimonial");
?>
