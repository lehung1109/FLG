<?php

/**
 * @file
 * Provides Inline Conditions integration for the Commerce Discount Saleprice module.
 */

/**
 * Implements hook_inline_conditions_info().
 */
function commerce_discount_saleprice_inline_conditions_info() {
  $conditions = array();

  $conditions['commerce_discount_product_has_saleprice'] = array(
    'label' => t('Product has saleprice'),
    'entity type' => 'commerce_line_item',
    'callbacks' => array(
      'configure' => 'commerce_discount_product_has_saleprice_configure',
      'build' => 'commerce_discount_product_has_saleprice_build',
    ),
  );

  return $conditions;
}

/**
 * Configuration callback for commerce_product_discount.
 *
 * @param array $settings
 *   Values for the form element.
 *
 * @return array
 *   Return a form element.
 */
function commerce_discount_product_has_saleprice_configure($settings) {
  $form = array();

  $form['dummy'] = array(
    '#type' => 'hidden',
    '#default_value' => 1,
  );
  
  return $form;
}