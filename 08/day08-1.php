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

$start  = 'AAA';
$target = 'ZZZ';
$map    = array();

foreach ( $line as $key => $value ) {
	$data = explode( ' = ', $value );
	$loc   = $data[0];
	$left  = substr( $data[1], 1, 3 );
	$right = substr( $data[1], 6, 3 );

	$map[ $loc ] = array(
		'left'  => $left,
		'right' => $right,
	);
}

$ord = str_split( 'LLRLLRRLRLRRRLRRLLRRRLRLRLRRLRRRLRRLRLRLLRLLLRRRLRRLRRRLRRRLRRRLRLRRLLRRLRRLRRLRRRLRLRRRLLRLRRLRRRLRLRRRLRRRLRLRRRLLRRRLRRRLRLRRLRLRRRLLRRLRRLRRLRRLRLRLRRRLLRRRLRRLRRRLRLRLRRRLLRLRRLLRLRRLRLRRRLRLRRLLRRRLLRRLRLRLLRLLRRLRRLLRRLRLRRLRLRLRRRLRRLRLLLLRRLRLRLRRRLLLRRRLRRLRRLRLLRLRRRLLLRRRLRRRLRRRR' );

$data = doloop( $start, 0 );

$loop_count = 0;
while ( $data['target'] !== $data['loc'] ) {
	$loop_count++;
	$start = $data['loc'];
	$step  = $data['step'];
	$data = doloop( $start, $step );
}

function doloop( $start, $step_count ) {
	global $ord, $map, $target;
	$loc = $start;
	foreach ( $ord as $key => $value ) {
		$step_count++;

		if ( 'L' === $value ) {
			$loc = $map[ $loc ]['left'];
		} else {
			$loc = $map[ $loc ]['right'];
		}

		if ( $target === trim( $loc ) ) {
			echo 'Found '. $target . ' in ' . $step_count . ' steps' . "\n";
			exit;
		}
	}
	return array(
		'loc' => $loc,
		'step' => $step_count,
		'target' => $target,
	);
}
