<?php
// Day 8 - Part 2.
// Haunted Wasteland.
// phpcs:ignoreFile

$ord = str_split( 'LLRLLRRLRLRRRLRRLLRRRLRLRLRRLRRRLRRLRLRLLRLLLRRRLRRLRRRLRRRLRRRLRLRRLLRRLRRLRRLRRRLRLRRRLLRLRRLRRRLRLRRRLRRRLRLRRRLLRRRLRRRLRLRRLRLRRRLLRRLRRLRRLRRLRLRLRRRLLRRRLRRLRRRLRLRLRRRLLRLRRLLRLRRLRLRRRLRLRRLLRRRLLRRLRLRLLRLLRRLRRLLRRLRLRRLRLRLRRRLRRLRLLLLRRLRLRLRRRLLLRRRLRRLRRLRLLRLRRRLLLRRRLRRRLRRRR' );

$i     = 1;
$order = array();
foreach ( $ord as $o ) {
	$order[ $i ] = $o;
	$i++;
}

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

$map    = array();
$starting_point  = array();
foreach ( $line as $key => $value ) {
	$data  = explode( ' = ', $value );
	$loc   = trim( $data[0] );
	$left  = substr( $data[1], 1, 3 );
	$right = substr( $data[1], 6, 3 );

	$map[ $loc ] = array(
		'L'  => $left,
		'R' => $right,
	);

	if( 'A' === substr( $loc, -1 ) ) {
		$starting_point[] = $loc;
	}
}

$found = array();
foreach ( $starting_point as $path ) {
	$stepcount  = 1;
	$ordercount = 1;

	while ( ! isset( $found[ $path ] ) ) {
		if ( $ordercount > count( $order ) ) {
			$ordercount = 1;
		}

		$path = trim( $map[ $path ][ $order[ $ordercount ] ] );

		if ( 'Z' === substr( $path, -1 ) ) {
			$found[ $path ] = $stepcount;
			continue;
		}
		$stepcount++;
		$ordercount++;
	}
}

$numbers = explode( ',', implode( ',', $found ) );
$lcd     = findLCD( $numbers );

echo $lcd;

function gcd($a, $b) {
    return $b ? gcd($b, $a % $b) : $a;
}

function lcm($a, $b) {
    return $a / gcd($a, $b) * $b;
}

function findLCD(array $numbers) {
    $lcd = $numbers[0];

    foreach ($numbers as $number) {
        $lcd = lcm($lcd, $number);
    }

    return $lcd;
}
