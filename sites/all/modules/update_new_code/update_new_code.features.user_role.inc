<?php
/**
 * @file
 * update_new_code.features.user_role.inc
 */

/**
 * Implements hook_user_default_roles().
 */
function update_new_code_user_default_roles() {
  $roles = array();

  // Exported role: Subcription.
  $roles['Subcription'] = array(
    'name' => 'Subcription',
    'weight' => 4,
  );

  return $roles;
}
