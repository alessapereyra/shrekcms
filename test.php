<html>
	<head>
	<title>Geomula</title>
 
	
	</head>
	
	<body>

<?php 

$a[1] = 1;
$a[5] = 1;
$a[20] = 1;

for($x = 1; $x <= 20; $x++)
{
	echo 'el numero ' . $x . ' es: ' . isset($a[$x]) . '<br />';
}
?>



	
	</body>
</html>