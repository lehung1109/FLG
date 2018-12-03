<?php
/**
 * @file
 * update_website_flg.features.inc
 */

/**
 * Implements hook_flag_default_flags().
 */
function update_website_flg_flag_default_flags() {
  $flags = array();
  // Exported flag: "Artist".
  $flags['artist'] = array(
    'entity_type' => 'node',
    'title' => 'Artist',
    'global' => 0,
    'types' => array(
      0 => 'artist',
      1 => 'contemporary',
    ),
    'flag_short' => 'Follow Artist',
    'flag_long' => '',
    'flag_message' => '',
    'unflag_short' => 'Unfollow Artist',
    'unflag_long' => '',
    'unflag_message' => '',
    'unflag_denied_text' => '',
    'link_type' => 'toggle',
    'weight' => 0,
    'show_in_links' => array(
      'full' => 'full',
      'teaser' => 'teaser',
      'rss' => 0,
      'ief_table' => 0,
      'email_plain' => 0,
      'email_html' => 0,
      'email_textalt' => 0,
      'token' => 0,
    ),
    'show_as_field' => 0,
    'show_on_form' => 0,
    'access_author' => '',
    'show_contextual_link' => 0,
    'i18n' => 0,
    'api_version' => 3,
    'module' => 'update_website_flg',
    'locked' => array(
      0 => 'name',
    ),
  );
  // Exported flag: "Favourite Art".
  $flags['favourite_art'] = array(
    'entity_type' => 'node',
    'title' => 'Favourite Art',
    'global' => 0,
    'types' => array(
      0 => 'art',
    ),
    'flag_short' => 'Favourite',
    'flag_long' => '',
    'flag_message' => '',
    'unflag_short' => 'UnFavourite',
    'unflag_long' => '',
    'unflag_message' => '',
    'unflag_denied_text' => '',
    'link_type' => 'toggle',
    'weight' => 0,
    'show_in_links' => array(
      'full' => 'full',
      'teaser' => 'teaser',
      'rss' => 0,
      'ief_table' => 0,
      'email_plain' => 0,
      'email_html' => 0,
      'email_textalt' => 0,
      'token' => 0,
    ),
    'show_as_field' => 0,
    'show_on_form' => 0,
    'access_author' => '',
    'show_contextual_link' => 0,
    'i18n' => 0,
    'api_version' => 3,
    'module' => 'update_website_flg',
    'locked' => array(
      0 => 'name',
    ),
  );
  return $flags;

}
