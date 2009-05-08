<?php
$sizes_name = array('thumbnail_size', 'medium_size', 'large_size');
 
foreach($sizes_name as $tmp_size)
{
	$tmp[$tmp_size . '_w'] = 3;
	$tmp[$tmp_size . '_h'] = 1;
	print_r($tmp);	 
}

?>