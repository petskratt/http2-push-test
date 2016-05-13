<?php
/**
 * Very simple data logger
 * User: peeter@zone.ee
 * Date: 13.05.2016
 * Time: 19:24
 */

$post_body = file_get_contents( 'php://input' );
$json      = json_decode( $post_body );

if ( isset( $json->loadTime ) ) {
	$log = [ date( DATE_ATOM ), $_SERVER['REMOTE_ADDR'], $_SERVER['SERVER_NAME'], (int) $json->loadTime ];

	if ( ! is_dir( 'logs' ) ) {
		mkdir( 'logs', 0755, true );
	}

	$logname = 'logs/timelog_' . $_SERVER['REMOTE_ADDR'] . '.csv';

	file_put_contents( $logname, implode( ';', $log ) . PHP_EOL, FILE_APPEND );
	echo "OK";
}

echo "Huh?";
