<html>
	<head>
	<title>Geomula</title>
 
	
	</head>
	
	<body>

<?php 

$texto = 'asdf-áasdasd234f';
$pattern = '/[^0-9a-zA-Z-]/';

echo preg_replace($pattern, '', trim($texto));

?>



	
	</body>
</html>