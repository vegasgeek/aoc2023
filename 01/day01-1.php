<?php
// Day 1 - Part 1.

$number = 0;
$file   = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

while ( ! feof( $file ) ) {
	$line = trim( fgets( $file, 1024 ) );

	$digits = filter_var( $line, FILTER_SANITIZE_NUMBER_INT );

	$first = substr( $digits, 0, 1 );
	$last  = substr( $digits, -1 );

	$number += intval( $first . $last );

}
fclose( $file );

echo $number;
