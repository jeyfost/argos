<?php

include('../connect.php');

function image_resize($source_path, $destination_path, $new_width, $quality = FALSE, $new_height = FALSE)
{
	ini_set("gd.jpeg_ignore_warning", 1);

	list($old_width, $old_height, $type) = getimagesize($source_path);

	switch($type)
	{
		case IMAGETYPE_JPEG:
			$typestr = 'jpeg';
			break;
		case IMAGETYPE_GIF:
			$typestr = 'gif';
			break;
		case IMAGETYPE_PNG:
			$typestr = 'png';
			break;
		default:
			break;
	}

	$function = "imagecreatefrom$typestr";
	$src_resource = $function($source_path);

	if(!$new_height)
	{
		$new_height = round($new_width * $old_height / $old_width);
	}
	elseif(!$new_width)
	{
		$new_width = round($new_height * $old_width / $old_height);
	}

	$destination_resource = imagecreatetruecolor($new_width, $new_height);

	imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

	if($type == 2)
	{
		imageinterlace($destination_resource, 1);
		imagejpeg($destination_resource, $destination_path, $quality);
	}
	else
	{
		$function = "image$typestr";
		$function($destination_resource, $destination_path);
	}

	imagedestroy($destination_resource);
	imagedestroy($src_resource);
}

function image_resize_h($source_path, $destination_path, $new_height, $quality = FALSE, $new_width = FALSE)
{
	ini_set("gd.jpeg_ignore_warning", 1);

	list($old_width, $old_height, $type) = getimagesize($source_path);

	switch($type)
	{
		case IMAGETYPE_JPEG:
			$typestr = 'jpeg';
			break;
		case IMAGETYPE_GIF:
			$typestr = 'gif';
			break;
		case IMAGETYPE_PNG:
			$typestr = 'png';
			break;
		default:
			break;
	}

	$function = "imagecreatefrom$typestr";
	$src_resource = $function($source_path);

	if(!$new_height)
	{
		$new_height = round($new_width * $old_height / $old_width);
	}
	elseif(!$new_width)
	{
		$new_width = round($new_height * $old_width / $old_height);
	}

	$destination_resource = imagecreatetruecolor($new_width, $new_height);

	imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

	if($type == 2)
	{
		imageinterlace($destination_resource, 1);
		imagejpeg($destination_resource, $destination_path, $quality);
	}
	else
	{
		$function = "image$typestr";
		$function($destination_resource, $destination_path);
	}

	imagedestroy($destination_resource);
	imagedestroy($src_resource);
}

function randomName($tmp_name)
{
	$name = md5(md5($tmp_name.date('d-m-Y H-i-s')));
	return $name;
}