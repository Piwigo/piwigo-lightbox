<?php
// Embedded Videos

define('PHPWG_ROOT_PATH','../../');
include_once(PHPWG_ROOT_PATH.'include/common.inc.php');
include_once(PHPWG_ROOT_PATH.'include/functions_picture.inc.php');

check_status(ACCESS_GUEST);

if (!isset($_GET['imgid']) or !is_numeric($_GET['imgid']))
{
  exit;
}

if (empty($pwg_loaded_plugins['gvideo']) or !function_exists('gvideo_element_content'))
{
  exit;
}

$image_id = pwg_db_real_escape_string($_GET['imgid']);

$query = '
SELECT *
  FROM '.IMAGES_TABLE.' 
    INNER JOIN '.IMAGE_CATEGORY_TABLE.' 
    ON id=image_id
  WHERE id='.$image_id
        . get_sql_condition_FandF(
            array('forbidden_categories' => 'category_id'),
            " AND"
          ).'
  LIMIT 1';

$picture = pwg_db_fetch_assoc( pwg_query($query) );

if (empty($picture) or !$picture['is_gvideo'])
{
  exit;
}

echo gvideo_element_content(null, $picture);

?>