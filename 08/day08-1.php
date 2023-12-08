<?php
// Day 8 - Part 1.
// Haunted Wasteland.
// phpcs:ignoreFile

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

$map_l = array();

foreach ( $line as $key => $value ) {
	$data = explode( ' = ', $value );

	$loc   = $data[0];
	$left  = substr( $data[1], 1, 3 );
	$right = substr( $data[1], 6, 3 );

	if ( ! isset( $start_l ) ) {
		$start_l = $loc;
	}

	$map_l[ $loc ] = array(
		'left'  => $left,
		'right' => $right,
	);
}

$ord_l = str_split( 'LLRLLRRLRLRRRLRRLLRRRLRLRLRRLRRRLRRLRLRLLRLLLRRRLRRLRRRLRRRLRRRLRLRRLLRRLRRLRRLRRRLRLRRRLLRLRRLRRRLRLRRRLRRRLRLRRRLLRRRLRRRLRLRRLRLRRRLLRRLRRLRRLRRLRLRLRRRLLRRRLRRLRRRLRLRLRRRLLRLRRLLRLRRLRLRRRLRLRRLLRRRLLRRLRLRLLRLLRRLRRLLRRLRLRRLRLRLRRRLRRLRLLLLRRLRLRLRRRLLLRRRLRRLRRLRLLRLRRRLLLRRRLRRRLRRRR' );

// test data //
$start_t = 'AAA';
$map_t = array();
$map_t[ 'AAA' ] = [ 'left' => 'BBB', 'right' => 'BBB' ];
$map_t[ 'BBB' ] = [ 'left' => 'AAA', 'right' => 'ZZZ' ];
$map_t[ 'ZZZ' ] = [ 'left' => 'ZZZ', 'right' => 'ZZZ' ];

$ord_t = str_split( 'LLR' );
///////////////

$use = 'l';

if ( 'l' === $use ) {
	$start = $start_l;
	$map   = $map_l;
	$ord   = $ord_l;
} else {
	$start = $start_t;
	$map   = $map_t;
	$ord   = $ord_t;
}

$data = doloop( $start, 0 );

$loop_count = 0;
while ( 'ZZZ' !== $data['loc'] ) {
	$loop_count++;
	$start = $data['loc'];
	$step  = $data['step'];
	$data = doloop( $start, $step );
}

function doloop( $start, $step_count ) {
	global $ord, $map;
	$loc = $start;
	foreach ( $ord as $key => $value ) {
		$step_count++;

		echo $step_count . ': ' . $loc . ' ' . $map[ $loc ]['left'] . ' ' . $map[ $loc ]['right'] . ' ' . $value;

		if ( 'L' === $value ) {
			$loc = $map[ $loc ]['left'];
		} else {
			$loc = $map[ $loc ]['right'];
		}

		echo ' | Found: ' . $loc . "\n";

		$target = 'ZZZ';
		if ( $target === trim( $loc ) ) {
			echo 'Found '. $target . ' in ' . $step_count . ' steps' . "\n";
			exit;
		}
	}
	return array(
		'loc' => $loc,
		'step' => $step_count,
	);
}
