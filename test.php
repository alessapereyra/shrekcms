<html>
	<head>
	<title>Geomula</title>
 
	
	</head>
	
	<body>

<?php //include('simple_html_dom.php');

$youtube = false;

$html = '<html><body>Hello!</body></html>';

$find = '[y';
$prim = strpos($html, $find);

$find = 'e]';
$ult = strrpos($html, $find) + 1;

$cant = $ult-$prim + 1;

$youtube =  substr($html, $prim, $cant);


echo $youtbe . 'a';

//echo $prim . ' ' . $ult;

?>



	
	</body>
</html>