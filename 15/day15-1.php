<?php
// Day 15: Lens Library
// https://adventofcode.com/2023/day/15
// phpcs:ignoreFile

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

while ( ! feof( $file ) ) {
	$input = trim( fgets( $file, 65535 ) );
}

$data = explode( ',', $input );

$results = array();
foreach ( $data as $key => $string ) {
	$val = dohash( $string );
	$results[] = $val;
}

$sum = array_sum( $results );
echo 'Sum: ' . $sum . "\n";

function dohash( $string ) {
	$val = 0;
	foreach ( str_split( $string ) as $char ) {

		$ord = ord( $char );
		$val = $val + $ord;
		$val = $val * 17;
		$val = $val % 256;
	}

	return $val;
}