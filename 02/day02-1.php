<?php
// Day 2 - Part 1.
// Do you want to play a game?


$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}
$removes = array( ' ', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0' );

$limit = array(
	'red'   => 12,
	'green' => 13,
	'blue'  => 14,
);

$parts = array();
while ( ! feof( $file ) ) {
	$game                = trim( fgets( $file, 1024 ) );
	$parts               = explode( ':', $game );
	$dice_count          = array();

	$game_num = intval( filter_var( $parts[0], FILTER_SANITIZE_NUMBER_INT ) );

	$round = explode( ';', $parts[1] );

	$valid = true;
	foreach ( $round as $key => $value ) {

		$dice                = explode( ',', $value );
		$dice_count['blue']  = 0;
		$dice_count['green'] = 0;
		$dice_count['red']   = 0;

		foreach ( $dice as $k => $v ) {
			$num   = intval( filter_var( $v, FILTER_SANITIZE_NUMBER_INT ) );
			$color = trim( str_replace( $removes, '', $v ) );

			$dice_count[ $color ] += $num;
		}

		if ( ( $dice_count['blue'] > $limit['blue'] ) || ( $dice_count['green'] > $limit['green'] ) || ( $dice_count['red'] > $limit['red'] ) ) {
			$valid = false;
		}
	}

	if ( $valid ) {
		$number += intval( $game_num );
	}
}

fclose( $file );

echo $number;
