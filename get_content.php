<?php

define('PHPWG_ROOT_PATH','../../');
include_once(PHPWG_ROOT_PATH.'include/common.inc.php');
include_once(PHPWG_ROOT_PATH.'include/functions_picture.inc.php');

check_status(ACCESS_GUEST);

if (!isset($_GET['imgid']) or !is_numeric($_GET['imgid']))
{
  die;
}

$image_id = mysql_real_escape_string($_GET['imgid']);

$query = '
SELECT *
  FROM '.IMAGES_TABLE.' INNER JOIN '.IMAGE_CATEGORY_TABLE.' ON id=image_id
  WHERE id='.$image_id
        . get_sql_condition_FandF(
            array('forbidden_categories' => 'category_id'),
            " AND"
          ).'
  LIMIT 1';

$picture['current'] = mysql_fetch_assoc( pwg_query($query) );

if (empty($picture['current']))
{
  die;
}

// PY Gvideo
if (!empty($py_addext) and in_array(get_extension($picture['current']['path']), $py_addext))
{
  $extension = strtolower(get_extension($picture['current']['path']));
  $picture['current']['path'] = get_element_url($picture['current']);
  include(GVIDEO_PATH.'gvideo.php');
  echo $content;  
}

?>