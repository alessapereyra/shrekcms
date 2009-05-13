<?php
if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '1',
'after_widget' => '2',
'before_title' => '3',
'after_title' => '4',
));
?>