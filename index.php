<?php
/**
 * HTTP 1.1 vs HTTP/2 vs HTTP/2 server push test
 * Uses logos from http://e-kaubanduseliit.ee/e-smaspaev/ ... as we were supporting the campaign when I wrote the test
 *
 * User: peeter@zone.ee
 * Date: 13.05.2016
 * Time: 19:24
 */

require_once 'merchants.inc.php';

// this set has been optimized with ImageOptim, use /img_original for larger files
$img_path = '/img_optimized';

$html = '';
$header = '';
$cachekiller = bin2hex( random_bytes( 5 ) );

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
<div class="timing">
	<p>Load time: <span id="loadTime"></span></p>
</div>
<?php echo $html; ?>
<script>

	window.addEventListener("load", function () {
		setTimeout(function () {
			var performance = window.performance || window.webkitPerformance || window.msPerformance || window.mozPerformance;

			if (performance === undefined) {
				return false;
			}

			var loadTime = performance.timing.loadEventEnd - performance.timing.fetchStart;
			console.log(loadTime);
			document.getElementById("loadTime").textContent = loadTime + 'ms';

			// well, we obviously are able to log the results :-)
			// you can find your log named by you IP address as logs/timelog_xxx.xxx.xxx.xxx.csv

			if (window.location.search.indexOf('log') > -1) {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("POST", "loghandler.php");
				xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
				xmlhttp.send(JSON.stringify({loadTime: loadTime}));
			}

		}, 0);
	}, false);

</script>
</body>
</html>