<?php
// Day 1 - Part 2.

$map = array(
	'oneight'   => 'oneeight',
	'threeight' => 'threeeight',
	'fiveight'  => 'fiveeight',
	'nineight'  => 'nineeight',
	'twone'     => 'twoone',
	'eightwo'   => 'eighttwo',
	'eighthree' => 'eightthree',
	'sevenine'  => 'sevennine',
	'one'       => '1',
	'two'       => '2',
	'three'     => '3',
	'four'      => '4',
	'five'      => '5',
	'six'       => '6',
	'seven'     => '7',
	'eight'     => '8',
	'nine'      => '9',
);

$number = 0;
$file   = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$count = 0;
while ( ! feof( $file ) ) {
	$line = trim( fgets( $file, 1024 ) );

	foreach ( $map as $key => $value ) {
		$line = str_replace( $key, $value, $line );
	}

	$digits = filter_var( $line, FILTER_SANITIZE_NUMBER_INT );

	$first = substr( $digits, 0, 1 );
	$last  = substr( $digits, -1 );

	$number += intval( $first . $last );
}
fclose( $file );

echo $number;
