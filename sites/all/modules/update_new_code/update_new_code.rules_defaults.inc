<?php
/**
 * @file
 * update_new_code.rules_defaults.inc
 */

/**
 * Implements hook_default_rules_configuration().
 */
function update_new_code_default_rules_configuration() {
  $items = array();
  $items['rules_redirect_after_update_user'] = entity_import('rules_config', '{ "rules_redirect_after_update_user" : {
      "LABEL" : "redirect after update user",
      "PLUGIN" : "reaction rule",
      "OWNER" : "rules",
      "REQUIRES" : [ "rules" ],
      "ON" : { "user_update" : [] },
      "DO" : [ { "redirect" : { "url" : "\\/node\\/4175?uid=[account:uid]" } } ]
    }
  }');
  $items['rules_send_mail_by_cron'] = entity_import('rules_config', '{ "rules_send_mail_by_cron" : {
      "LABEL" : "Send mail by cron",
      "PLUGIN" : "reaction rule",
      "OWNER" : "rules",
      "REQUIRES" : [ "php", "rules" ],
      "ON" : { "cron" : [] },
      "DO" : [ { "php_eval" : { "code" : "sentius_send_mail_cron();" } } ]
    }
  }');
  return $items;
}
