<?php
/**
 * @file
 * commerce_discount_saleprice.rules_defaults.inc
 */

/**
 * Implements hook_default_rules_configuration_alter().
 * 
 * Disabling commerce_saleprice rules if any.
 */
function commerce_discount_saleprice_default_rules_configuration_alter(&$configs) {
  unset($configs['rules_commerce_saleprice_component']);
  unset($configs['rules_commerce_saleprice_rule']);
}
