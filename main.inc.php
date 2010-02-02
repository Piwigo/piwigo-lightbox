<?php
/*
Plugin Name: Lightbox
Version: auto
Description: Display pictures in a lightbox.
Plugin URI: http://fr.piwigo.org/ext/extension_view.php?eid=280
Author: P@t
Author URI: http://www.gauchon.com
*/

define('LIGHTBOX_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

add_event_handler('init', 'load_jquery_lightbox_plugin');
add_event_handler('loc_end_index_thumbnails', 'lightbox_plugin', 40, 2);

function load_jquery_lightbox_plugin()
{
  global $template;

  $template->func_known_script(array('id'=>'jquery', 'src'=>get_root_url().'plugins/lightbox/jquery.min.js'), $smarty);
}

function lightbox_plugin($tpl_thumbnails_var, $pictures)
{
  include(LIGHTBOX_PATH . 'lightbox.php');
  return $tpl_thumbnails_var;
}

if (script_basename()  == 'admin')
  include(dirname(__FILE__).'/admin/functions.inc.php');

?>