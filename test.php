<?php
	function sanitize2url($str, $extras = NULL)
	{
		$pattern = array('/ñ/','/á/', '/é/', '/í/', '/ó/', '/ú/');
		if ($extras != NULL)
		{
			foreach($extras as $extra)
			{
				$pattern[] = '/' . $extra . '/';
			}
			//$pattern = array_merge($pattern, $extras);
		}
		$str = preg_replace($pattern, '', strtolower(trim($str)));
		return $str;
	}
	
	echo sanitize2url('el velñoz', array('z'));
?>