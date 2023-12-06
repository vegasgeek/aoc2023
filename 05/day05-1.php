<?php
// Day 5 - Part 1.
// Let's plant some stuff.
// https://adventofcode.com/2023/day/5

// $file = fopen( 'data.txt', 'r' );
// if ( ! $file ) {
// 	exit;
// }

// $line = array();
// while ( ! feof( $file ) ) {
// 	$line[] = trim( fgets( $file, 1024 ) );
// }

$soil_map  = array();
$fert_map  = array();
$water_map = array();
$light_map = array();
$temp_map  = array();
$humid_map = array();
$loc_map   = array();

$s_to_s = array(
	array(
		'dest_start'   => 50, // num to move to next column
		'source_start' => 98, // array key to place number at
		'length'       => 2,  // how many spots to fill in
	),
	array(
		'dest_start' => 52,
		'source_start' => 50,
		'length' => 48,
	),
);

foreach ( $s_to_s as $key => $value ) {
	$dest   = $value['dest_start'];
	$source = $value['source_start'];
	$length = $value['length'];

	while ( $length > 0 ) {
		$soil_map[ $source ] = $dest;
		$dest++;
		$source++;
		$length--;
	}
}

$s_to_f = array(
	array(
		'dest_start' => 0,    // num to move to next column
		'source_start' => 15, // array key to place number at
		'length' => 37,       // how many spots to fill in
	),
	array(
		'dest_start' => 37,
		'source_start' => 52,
		'length' => 2,
	),
	array(
		'dest_start' => 39,
		'source_start' => 0,
		'length' => 15,
	),
);

foreach ( $s_to_f as $key => $value ) {
	$dest   = $soil_map[ $value['dest_start'] ];
	$source = $value['source_start'];
	$length = $value['length'];

	while ( $length > 0 ) {
		$fert_map[ $source ] = $dest;
		$dest++;
		$source++;
		$length--;
	}
}

$f_to_w = array(
	array(
		'dest_start' => 49,
		'source_start' => 53,
		'length' => 8,
	),
	array(
		'dest_start' => 0,
		'source_start' => 11,
		'length' => 42,
	),
	array(
		'dest_start' => 42,
		'source_start' => 0,
		'length' => 7,
	),
	array(
		'dest_start' => 57,
		'source_start' => 7,
		'length' => 4,
	),
);

foreach ( $f_to_w as $key => $value ) {
	$dest   = $fert_map[ $value['dest_start'] ];
	$source = $value['source_start'];
	$length = $value['length'];

	while ( $length > 0 ) {
		$water_map[ $source ] = $dest;
		$dest++;
		$source++;
		$length--;
	}
}

$w_to_l = array(
	array(
		'dest_start' => 88,
		'source_start' => 18,
		'length' => 7,
	),
	array(
		'dest_start' => 18,
		'source_start' => 25,
		'length' => 70,
	),
);

foreach ( $w_to_l as $key => $value ) {
	echo $water_map[ $value['dest_start'] ] . "\n";
	print_r( $value );
	$dest   = $water_map[ $value['dest_start'] ];
	$source = $value['source_start'];
	$length = $value['length'];

	while ( $length > 0 ) {
		$light_map[ $source ] = $dest;
		$dest++;
		$source++;
		$length--;
	}
}

$l_to_t = array(
	array(
		'dest_start' => 45,
		'source_start' => 77,
		'length' => 23,
	),
	array(
		'dest_start' => 81,
		'source_start' => 45,
		'length' => 19,
	),
	array(
		'dest_start' => 68,
		'source_start' => 64,
		'length' => 13,
	),
);

foreach ( $l_to_t as $key => $value ) {
	$dest   = $light_map[ $value['dest_start'] ];
	$source = $value['source_start'];
	$length = $value['length'];

	while ( $length > 0 ) {
		$temp_map[ $source ] = $dest;
		$dest++;
		$source++;
		$length--;
	}
}

$t_to_h = array(
	array(
		'dest_start' => 0,
		'source_start' => 69,
		'length' => 1,
	),
	array(
		'dest_start' => 1,
		'source_start' => 0,
		'length' => 69,
	),
);

foreach ( $t_to_h as $key => $value ) {
	$dest   = $temp_map[ $value['dest_start'] ];
	$source = $value['source_start'];
	$length = $value['length'];

	while ( $length > 0 ) {
		$humid_map[ $source ] = $dest;
		$dest++;
		$source++;
		$length--;
	}
}

$h_to_l = array(
	array(
		'dest_start' => 60,
		'source_start' => 56,
		'length' => 37,
	),
	array(
		'dest_start' => 56,
		'source_start' => 93,
		'length' => 4,
	),
);

foreach ( $h_to_l as $key => $value ) {
	$dest   = $humid_map[ $value['dest_start'] ];
	$source = $value['source_start'];
	$length = $value['length'];

	while ( $length > 0 ) {
		$loc_map[ $source ] = $dest;
		$dest++;
		$source++;
		$length--;
	}
}

$seed = 79;
$soild = $soil_map[ $seed ] ?? $seed;
$fertd = $fert_map[ $soild ] ?? $soild;
$waterd = $water_map[ $fertd ] ?? $fertd;
$lightd = $light_map[ $waterd ] ?? $waterd;
$tempd = $temp_map[ $lightd ] ?? $lightd;
$humidd = $humid_map[ $tempd ] ?? $tempd;
$locd = $loc_map[ $humidd ] ?? $humidd;

// print_r( $soil_map );
// print_r( $fert_map );
// print_r( $water_map );
echo 'Seed: ' . $seed . "\n";
echo 'Soil: ' . $soild . "\n";
echo 'Fert: ' . $fertd . "\n";
echo 'Water: ' . $waterd . "\n";
echo 'Light: ' . $lightd . "\n";
echo 'Temp: ' . $tempd . "\n";
echo 'Humid: ' . $humidd . "\n";
echo 'Loc: ' . $locd . "\n";