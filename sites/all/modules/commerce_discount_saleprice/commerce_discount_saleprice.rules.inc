<?php

/**
 * @file
 * commerce_discount_saleprice.rules.inc
 */

/**
 * Implements hook_rules_condition_info().
 */
function commerce_discount_saleprice_rules_condition_info() {
  $inline_conditions = inline_conditions_get_info();
  
  $conditions = array();

  $conditions['commerce_discount_product_has_saleprice'] = array(
    'label' => t('Line item product discount price'),
    'parameter' => array(
      'commerce_line_item' => array(
        'type' => 'commerce_line_item',
        'label' => t('Line item'),
        'description' => t('The line item.'),
        'wrapped' => TRUE,
      ),
    ),
    'module' => 'commerce_discount_saleprice',
    'group' => t('Commerce Line Item'),
    'callbacks' => array(
      'execute' => $inline_conditions['commerce_discount_product_has_saleprice']['callbacks']['build'],
    ),
  );

  return $conditions;
}

/**
 * Build callback for saleprice_discount.
 *
 * @param EntityDrupalWrapper $wrapper
 *   Wrapped entity type given by the rule.
 *
 * @return bool
 *   True if condition is valid. false otherwise.
 */
function commerce_discount_product_has_saleprice_build(EntityDrupalWrapper $wrapper) {
  return commerce_discount_saleprice_line_item_has_saleprice($wrapper);
}
