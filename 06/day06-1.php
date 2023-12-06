<?php
// Day 6 - Part 1.
// Let's race!
// https://adventofcode.com/2023/day/6

// Time:        35     69     68     87
// Distance:   213   1168   1086   1248

$races = array (
	array(
		'time' => 35,
		'dist' => 213,
	),
	array(
		'time' => 69,
		'dist' => 1168,
	),
	array(
		'time' => 68,
		'dist' => 1086,
	),
	array(
		'time' => 87,
		'dist' => 1248,
	),
);

$results  = array();
$race_num = 0;

foreach ( $races as $race ) {
	$race_num++;
	$time = $race['time'];
	$dist = $race['dist'];
	$remaining_time = $time;
	$hold = 0;
	$win_count = 0;
	$loss_count = 0;

	while ( $hold <= $time ) {
		$our_distance   = $hold * $remaining_time;

		if ( $our_distance > $dist ) {
			$win_count++;
		}
		$hold++;
		$remaining_time--;
	}

	$results[ $race_num ] = array(
		'win'  => $win_count,
		'lose' => $lose_count,
	);
}

$product = 1;
foreach ( $results as $result ) {
	if ( array_key_exists( 'win', $result ) ) {
		$product *= $result['win'];
	}
}

echo $product;
