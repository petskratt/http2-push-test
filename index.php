<?php
/**
 * HTTP 1.1 vs HTTP/2 vs HTTP/2 server push test
 * Uses logos from http://e-kaubanduseliit.ee/e-smaspaev/ ... as we were supporting the campaign when I wrote the test
 *
 * User: peeter@zone.ee
 * Date: 06.05.2016
 * Time: 12:53
 */

require_once 'merchants.inc.php';

// this set has been optimized with ImageOptim, use /img_original for larger files
$img_path = '/img_optimized';

$html = '';
$header = '';
$cachekiller = bin2hex(random_bytes(5));

foreach ( $merchants as $alt => $image ) {
	$html .= "<img src='$img_path/$image?ck$cachekiller' width='175' height='75' alt='$alt'>";
	$header .= "<$img_path/$image?ck$cachekiller>; rel=preload, ";
}

if ( isset( $_GET['push'] ) ) {
	header( "Link: $header" );
}

?><!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="UTF-8">
	<title>E-smaspäev!</title>
</head>
<body>
<?php echo $html; ?>
</body>
</html>