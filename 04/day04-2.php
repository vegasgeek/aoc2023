<?php
// Day 4 - Part 2.
// Scratch and Win!

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

$card        = 0;
$cards       = array();
$copies      = array();
$total_cards = array();
foreach ( $line as $key => $value ) {
	$card++;
	$nums = substr( $value, 8 );

	$set = explode( '|', $nums );

	$winners = explode( ' ', $set[0] );
	$numbers = explode( ' ', $set[1] );

	$winners        = array_filter( $winners, 'is_numeric' );
	$numbers        = array_filter( $numbers, 'is_numeric' );
	$matches        = array_intersect( $winners, $numbers );
	$cards[ $card ] = array(
		'matches' => count( $matches ),
		'total'   => 1,
	);
}

foreach ( $cards as $card => $value ) {
	$matches   = $value['matches'];
	$total     = $value['total'];
	$next_card = $card + 1;

	for ( $i = 0; $i < $matches; $i++ ) {
		$cards[ $next_card ]['total'] += $cards[ $card ]['total'];
		$next_card++;
	}
}

$total = 0;
foreach ( $cards as $card => $value ) {
	$total += $value['total'];
}

echo $total;
