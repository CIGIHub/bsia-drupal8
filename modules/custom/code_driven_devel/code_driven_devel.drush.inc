<?php
/**
 * Implements hook_drush_command().
 */
function code_driven_devel_drush_command() {

  $items['override-block-uuids'] = array(
    'description' => 'Override all custom block UUIDs with the configured UUIDs in the YML files.',
    'aliases' => array('obu'),
    'arguments' => array(
      'configuration-name' => 'The name of the configuration directory to use. Required.',
    ),
    'drupal dependencies' => array('code_driven_devel'),
  );
  $items['override-local-uuids'] = array(
    'description' => 'Override all local UUIDs with the configured UUIDs in the YML files.',
    'aliases' => array('olu'),
    'drupal dependencies' => array('code_driven_devel'),
  );

  return $items;
}

/**
 * Callback for the override-block-uuids command
 */
function drush_code_driven_devel_override_block_uuids($configuration_name) {
  code_driven_devel_override_block_uuids($configuration_name);
}

/**
 * Callback for the override-local-uuids command
 */
function drush_code_driven_devel_override_local_uuids() {
  drupal_set_message(t('Not Implemented!'));
}
