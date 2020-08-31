<?php
/**
 * @file
 * feeds_import.feeds_importer_default.inc
 */

/**
 * Implements hook_feeds_importer_default().
 */
function flg_feeds_import_feeds_importer_default() {
  $export = array();

  $feeds_importer = new stdClass();
  $feeds_importer->disabled = FALSE; /* Edit this to true to make a default feeds_importer disabled initially */
  $feeds_importer->api_version = 1;
  $feeds_importer->id = 'node';
  $feeds_importer->config = array(
    'name' => 'Import Product Reference',
    'description' => 'Import Product reference from CSV file.',
    'fetcher' => array(
      'plugin_key' => 'FeedsFileFetcher',
      'config' => array(
        'direct' => FALSE,
      ),
    ),
    'parser' => array(
      'plugin_key' => 'FeedsCSVParser',
      'config' => array(
        'delimiter' => ',',
      ),
    ),
    'processor' => array(
      'plugin_key' => 'FeedsNodeProcessor',
      'config' => array(
        'bundle' => 'art',
        'update_existing' => 2,
        'insert_new' => 0,
        'expire' => '-1',
        'mappings' => array(
          0 => array(
            'source' => 'Nid',
            'target' => 'nid',
            'unique' => TRUE,
          ),
          1 => array(
            'source' => 'Nid',
            'target' => 'product_reference:sku',
            'unique' => FALSE,
          ),
        ),
        'input_format' => 'plain_text',
        'author' => 0,
      ),
    ),
    'content_type' => '',
    'update' => 0,
    'import_period' => '-1',
    'expire_period' => 3600,
    'import_on_create' => 1,
  );
  $export['flg_feeds_import_import_product_reference'] = $feeds_importer;

  // add feed import art product
  $feeds_importer = new stdClass();
  $feeds_importer->disabled = FALSE; /* Edit this to true to make a default feeds_importer disabled initially */
  $feeds_importer->api_version = 1;
  $feeds_importer->id = 'product_importer';
  $feeds_importer->config = array(
    'name' => 'Import Art Product',
    'description' => 'Import Art Product from CSV file.',
    'fetcher' => array(
      'plugin_key' => 'FeedsFileFetcher',
      'config' => array(
        'direct' => FALSE,
      ),
    ),
    'parser' => array(
      'plugin_key' => 'FeedsCSVParser',
      'config' => array(
        'delimiter' => ',',
      ),
    ),
    'processor' => array(
      'plugin_key' => 'FeedsCommerceProductProcessor',
      'config' => array(
        'product_type' => 'product',
        'author' => '1',
        'update_existing' => '2',
        'insert_new' => 1,
        'expire' => '-1',
        'bundle' => 'product',
        'mappings' => array(
          0 => array(
            'source' => 'Nid',
            'target' => 'sku',
            'unique' => 1,
          ),
          1 => array(
            'source' => 'Title',
            'target' => 'title',
            'unique' => FALSE,
          ),
          2 => array(
            'source' => 'Price',
            'target' => 'commerce_price:amount',
            'unique' => FALSE,
          ),
          3 => array(
            'source' => 'Sale Price',
            'target' => 'field_commerce_saleprice:amount',
            'unique' => FALSE,
          ),
          4 => array(
            'source' => 'Sale Price',
            'target' => 'field_commerce_saleprice_on_sale',
            'unique' => FALSE,
          ),
          5 => array(
            'source' => 'Stock',
            'target' => 'commerce_stock',
            'unique' => FALSE,
          ),
        ),
      ),
    ),
    'content_type' => '',
    'update' => 0,
    'import_period' => '-1',
    'expire_period' => 3600,
    'import_on_create' => 1,
  );

  $export['flg_feeds_import_import_art_product'] = $feeds_importer;

  return $export;
}
