<?php
// Day 14: Parabolic Reflector Dish
// https://adventofcode.com/2023/day/14
// phpcs:ignoreFile

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

$len  = strlen( $line[0] );
$rows = count( $line );

$map = array();
foreach ( $line as $key => $value ) {
	$map = array_merge( $map, str_split( $value ) );
}
$max = count( $map ) - 1;

$stones = array( '#', 'O' );

for( $i = 0; $i < $rows; $i++ ) {

	foreach ( $map as $key => $value ) {
		$curpos   = $key;
		$curitem  = $value;
		$nextpos  = $curpos + $len;

		if ( $nextpos > $max ) {
			continue;
		}


		$nextitem = $map[ $nextpos ];

		if ( in_array( $curitem, $stones ) ) {
			continue;
		}

		if ( '#' === $nextitem ) {
			continue;
		}

		$map[ $curpos ] = $nextitem;
		$map[ $nextpos ] = '.';
	}
}

$score = 0;
$cur_row = $rows;
foreach ( $map as $key => $value ) {
	if ( $key % $len === 0 && $key !== 0 ) {
		$cur_row--;
	}

	if ( $value === 'O' ) {
		$score += $cur_row;
	}
}

echo 'Total Score: ' . $score;
