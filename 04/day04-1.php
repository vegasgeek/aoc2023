<?php
// Day 4 - Part 1.
// Scratch and Win!

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

$card   = 0;
$cards  = array();
foreach ( $line as $key => $value ) {
	$card++;
	$nums = substr( $value, 10 );

	$set = explode( '|', $nums );

	$winners = explode( ' ', $set[0] );
	$numbers = explode( ' ', $set[1] );

	// remove any array elements that are non-numeric.
	$winners = array_filter( $winners, 'is_numeric' );
	$numbers = array_filter( $numbers, 'is_numeric' );
	$matches = array_intersect( $winners, $numbers );
	$cards[] = array(
		'num'     => $card,
		'matches' => count( $matches ),
	);
}

$total = 0;
foreach ( $cards as $card ) {
	$points = match ( $card['matches'] ) {
		0 => 0,
		1 => 1,
		2 => 2,
		3 => 4,
		4 => 8,
		5 => 16,
		6 => 32,
		7 => 64,
		8 => 128,
		9 => 256,
		10 => 512,
		default => 0,
	};

	$total += $points;
}

echo $total;
