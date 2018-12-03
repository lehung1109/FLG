<?php
/**
 * @file
 * update_website_flg.features.taxonomy.inc
 */

/**
 * Implements hook_taxonomy_default_vocabularies().
 */
function update_website_flg_taxonomy_default_vocabularies() {
  return array(
    'tags_artwork' => array(
      'name' => 'Tags artwork',
      'machine_name' => 'tags_artwork',
      'description' => '',
      'hierarchy' => 0,
      'module' => 'taxonomy',
      'weight' => 0,
    ),
  );
}
