<?php
function change_text_widget_config($field_name, $widget_type, $text_processing) {
    var_dump($field_name);

    // Fetch the current field configuration
    $query_results = db_query("SELECT global_settings FROM {content_node_field} WHERE field_name = 'field_%s'", $field_name);

    // We assume that there is only one entry in the table for each field
    $global_settings = db_result($query_results);
    var_dump($global_settings);

    // This is a serialized PHP array (i.e. stored as a string), so unserialize it
    $data = unserialize($global_settings);
    var_dump($data);

    // Update the text_processing entry; "0" to disable text processing, "1" to enable text processing
    $data['text_processing'] = $text_processing;

    // Update the field config
    var_dump(serialize($data));
    db_query("UPDATE {content_node_field} SET global_settings = '%s' WHERE field_name = 'field_%s'", serialize($data), $field_name);

    // Update the widget_type
    db_query("UPDATE {content_node_field_instance} SET widget_type = '%s' WHERE field_name = 'field_%s'", $widget_type, $field_name);
}

// $json = '{ "unlimited": {"a":1,"b":2,"c":3,"d":4,"e":5} }';
$json_field_config = '{
    "feature_line": {"widget":"text_textfield", "processing":"0", "content_types": ["event", "news", "page", "person", "publication", "research"]},
    "quote": {"widget":"text_textfield", "processing":"0", "content_types": ["person"]},
    "research_focus": {"widget":"text_textfield", "processing":"0", "content_types": ["person"]},
    "short_bio": {"widget":"text_textfield", "processing":"0", "content_types": ["person"]},
    "short_description": {"widget":"text_textfield", "processing":"0", "content_types": ["event","external_publication","news","publication","research"]},
    "testimonial": {"widget":"text_textfield", "processing":"0", "content_types": ["person"]}
}';
// var_dump(json_decode($json_field_config));
// var_dump(json_decode($json_field_config, true));

$field_config = json_decode($json_field_config, true);
foreach ($field_config as $field_name => $v) {
    $widget_type = $v["widget"];
    $text_processing = $v["processing"];
    change_text_widget_config($field_name, $widget_type, $text_processing);
}
?>
