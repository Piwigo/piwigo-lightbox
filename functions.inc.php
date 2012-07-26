<?php

// Return picture lightbox picture URL for known extension
function get_lightbox_url($picture)
{
  global $conf, $py_addext;

  $ext = get_extension($picture['file']);
  if (in_array($ext, $conf['picture_ext']))
  {
    return DerivativeImage::url(IMG_LARGE, new SrcImage($picture));
  }
  elseif (isset($py_addext) and in_array($ext, $py_addext))
  {
    return get_root_url().'plugins/lightbox/get_content.php?imgid='.$picture['id'];
  }
  return false;
}

// Return lightbox title
function get_lightbox_title($picture, $name_link)
{
  global $conf, $user;

  if (isset($picture['name']) and $picture['name'] != '')
  {
    $name = trigger_event('render_element_description', $picture['name']);
  }
  else
  {
    $name = str_replace('_', ' ', get_filename_wo_extension($picture['file']));
  }

  if ($name_link == 'picture')
  {
    $url = duplicate_picture_url(
      array(
        'image_id' => $picture['id'],
        'image_file' => $picture['file']
      ),
      array('start')
    );
    return htmlspecialchars('<a href="'.$url.'">'.$name.'</a>');
  }
  elseif ($name_link == 'high' and $picture['has_high'] and $user['enabled_high']=='true')
  {
    include_once(PHPWG_ROOT_PATH . 'include/functions_picture.inc.php');
    return htmlspecialchars('<a href="javascript:phpWGOpenWindow(\''.get_high_url($picture).'\',\'\',\'scrollbars=yes,toolbar=no,status=no,resizable=yes\')">'.$name.'</a>');
  }
  return $name;
}

// Return extra picture for multipage category
function get_lightbox_extra_pictures($selection, $rank_of, $name_link)
{
  global $conf;

  $query = 'SELECT * FROM '.IMAGES_TABLE.' WHERE id IN ('.implode(',', $selection).');';
  $result = pwg_query($query);
  $pictures = array();
  while ($row = mysql_fetch_assoc($result))
  {
    $row['rank'] = $rank_of[ $row['id'] ];
    array_push($pictures, $row);
  }
  usort($pictures, 'rank_compare');
  
  $content = '<div class="thumbnails" style="display: none;">'."\n";
  foreach ($pictures as $picture)
  {
    $content .= '<a href="#" id="img-'.$picture['id'].'" name="'.get_lightbox_url($picture).'" title="'.get_lightbox_title($picture, $name_link).'" rel="colorbox'.$conf['lightbox_rel'].'"></a>'."\n";
  }
  $content .= '</div>'."\n";
  
  return $content;
}

?>