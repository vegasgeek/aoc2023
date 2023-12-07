<?php
// Day 6 - Part 2.
// Let's race!
// https://adventofcode.com/2023/day/6

// Time:       35696887
// Distance:   213116810861248

$races = array (
	array(
		'time' => 35696887,
		'dist' => 213116810861248,
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

	while ( $hold <= $time ) {
		$our_distance   = $hold * $remaining_time;

		if ( $our_distance > $dist ) {
			$win_count++;
		}
		$hold++;
		$remaining_time--;
	}
}

echo $win_count;
