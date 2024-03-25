<?php
/*
Plugin Name: Lightbox
Version: auto
Description: Display pictures in a lightbox.
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=280
Author: P@t
Author URI: http://www.gauchon.com
Has Settings: webmaster
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

if (basename(dirname(__FILE__)) != 'lightbox')
{
  add_event_handler('init', 'lightbox_error');
  function lightbox_error()
  {
    global $page;
    $page['errors'][] = 'Lightbox folder name is incorrect, uninstall the plugin and rename it to "lightbox"';
  }
  return;
}

define('LIGHTBOX_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

add_event_handler('loc_end_index_thumbnails', 'lightbox_plugin', 40, 2);

function lightbox_plugin($tpl_thumbnails_var, $pictures)
{
  include(LIGHTBOX_PATH . 'lightbox.php');
  return $tpl_thumbnails_var;
}

if (script_basename()  == 'admin')
  include(dirname(__FILE__).'/admin/functions.inc.php');

?>
