<?php
/**
 * d6to7_cck_textfield_length_checker.php, a script to find Drupal 6
 * CCK text fields that are longer than 255 characters.
 *
 * Written by Mark Jordan, mjordan@sfu.ca and released into the
 * public domain.
 *
 * Upgrading to Drupal 7 from Drupal 6 instances that use CCK can
 * go horribly wrong. One example is if you have textfields that
 * do not specify a maximum length, your users can add content to
 * them that is longer than the corresponding field type in Drupal 7
 * allows. This problem is documented in a 'major' upgrade path bug
 * for CCK 7 (i.e., Content Migrate) at https://drupal.org/node/1117028.
 *
 * This script will not ensure a trouble-free upgrade, but it will identify
 * D6 CCK fields of type 'text_textfield' for you. The script does not
 * modify your Drupal database, it only reads from it.
 *
 * To run the script:
 *
 * 1) Edit the $cck_type varibles.
 * 2) Upload this script to your Drupal server and run it using drush,
 * e.g. drush d6to7_cck_textfield_checker.php.
 * 3) After it has completed running, it will print out all instances
 *    of text_textfield fields that contain values longer than 225
 *     characters.
 *
 * If you find any such fields, you will need to perform some manual work.
 * Here is what I did (please note: use this method at your own risk, I
 * am not responsible for this not working on your Drupal instance):
 *
 * 1) Edit any instances of fields reported by this script to contain
 *    values longer than 255 characters.
 * 2) In the content type you analyzed with this script, go to the
 *    field's configuration settings.
 * 3) At the bottom of the settings page, add '255' in the 'Maximum length'
 *    field and save the settings.
 * 4) To prepare to run Content Migrate (part of the 7.x-2.x-dev of CCK),
 *    you should add a maximum length to *all* fields of type text_textfield
 *    (not just to fields that were reported by this script). Content Migrate
 *    will warn you if you have any text_textfield fields that do not have
 *    a maximum length setting, but the whole point of this script is so that
 *    you never have to see those warnings.
 *
 * Other approaches to handling the upgrade are documented in the issue
 * linked above. YMMV.
 *
 * Updated by Daniel Mundra, dmundra@uoregon.edu, 2014-05-29
 * I removed the bootstrap code as you can run this script with drush without
 * needing to bootstrap. Also drush allows you run the code for site in a
 * multi-site environment.
 */
$drush_args = drush_get_arguments();
$cck_type = $drush_args[2];

// To get rid of the NOTICES resulting from undefined HTTP environment vars.
error_reporting(E_ALL ^ E_NOTICE);
/**
 * Get all fields for $cck_type.
 */
$type = content_types($cck_type);
$fields = $type['fields'];
/**
 * Pick out all the fields of type 'text_textfield'.
 */
print "Getting all CCK fields of type 'text_textfield'...\n";
$text_fields = array();
foreach ($fields as $field) {
  if ($field['widget']['type'] == 'text_textfield') {
    $text_fields[] = $field['field_name'];
  }
}
/**
 * Get all nodes of type $cck_type.
 */
print "Getting all nodes of type '$cck_type'...\n";
$result = db_query("SELECT nid FROM {node} WHERE type = '$cck_type' ORDER By nid");
while ($nids = db_fetch_object($result)) {
  $theses_nids[] = $nids->nid;
}
/**
 * Iterate through each node and test all the values in all
 * the fields we are interested in.
 */
print "Checking all field values in all nodes of type $cck_type for length greater than 255 characters...\n";
$properties = array();
foreach ($theses_nids as $nid) {
  $node = node_load($nid);
  foreach ($node as $property => $value) {
    if (in_array($property, $text_fields)) {
      foreach ($value as $member) {
        $length =  strlen($member['value']);
        // If the length of a value is longer than 255, report it.
        if ($length >= 255) {
          print "In node " . $node->nid . ", " . $property .
            " has the following value that is longer than 255 characters (value is $length characters long): " .
            $member['value'] . " \n";
          if (!in_array($property, $properties)) {
          	array_push($properties, $property);
          }
        }
      }
    }
  }
}
var_dump($properties);
?>
