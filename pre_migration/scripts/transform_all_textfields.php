<?php
// Note that you need to specify the table name as some field are contained in the table for the content_type and others are not
function transform_textfield($table, $field_name, $max_length) {
    //$table = 'content_type_' . $content_type;
    $column = 'field_' . $field_name . '_value';

    var_dump($table);
    var_dump($column);

    // Update field type
    $new_column = $column;
    $new_definition = array(
        'type' => 'varchar',
        'length' => $max_length,
    );
    db_change_field($ret, $table, $column, $new_column, $new_definition);

    // Fetch the current field configuration
    $query_results = db_query("SELECT global_settings FROM {content_node_field} WHERE field_name = 'field_%s'", $field_name);

    // We assume that there is only one entry in the table for each field
    $global_settings = db_result($query_results);
    var_dump($global_settings);

    // This is a serialized PHP array (i.e. stored as a string), so unserialize it
    $data = unserialize($global_settings);
    var_dump($data);

    // Update the max_length entry
    $data['max_length'] = $max_length;

    // Update the field config
    var_dump(serialize($data));
    db_query("UPDATE {content_node_field} SET global_settings = '%s' WHERE field_name = 'field_%s'", serialize($data), $field_name);
}

// $json = '{ "deprecated": {"a":1,"b":2,"c":3,"d":4,"e":5} }';
// not awards, linkedin_url, publications, subtitle
$json_field_config = '{
    "board_position": {"length":255, "content_types": ["person"]},
    "courses": {"length":255, "content_types": ["person", "deprecated"]},
    "credit": {"length":255, "content_types": ["event","news","page","person","publication","research"]},
    "department": {"length":255, "content_types": ["person"]},
    "education": {"length":255, "content_types": ["person", "deprecated"]},
    "email": {"length":255, "content_types": ["person"]},
    "expertise": {"length":255, "content_types": ["person", "deprecated"]},
    "given_names": {"length":255, "content_types": ["person"]},
    "graduate_title": {"length":255, "content_types": ["person"]},
    "languages": {"length":255, "content_types": ["person"]},
    "link_text": {"length":255, "content_types": ["event","news","page","person","publication","research"]},
    "office_location": {"length":255, "content_types": ["person"]},
    "person_position": {"length":255, "content_types": ["person"]},
    "phone": {"length":255, "content_types": ["person"]},
    "surname": {"length":255, "content_types": ["person"]},
    "twitter_url": {"length":255, "content_types": ["person"]},
    "website": {"length":255, "content_types": ["event","person","research"]},
    "year_graduated": {"length":255, "content_types": ["person"]},
    "youtube_id": {"length":255, "content_types": ["person"]}
}';
// var_dump(json_decode($json_field_config));
// var_dump(json_decode($json_field_config, true));

$field_config = json_decode($json_field_config, true);
foreach ($field_config as $field_name => $v) {
    $max_length = $v["length"];
    if (count($v["content_types"]) > 1) {
        $table = 'content_field_' . $field_name;
    }
    else {
        $table = 'content_type_' . $v["content_types"][0];
    }
    transform_textfield($table, $field_name, $max_length);
}
?>
