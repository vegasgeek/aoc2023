<?php
// Day 10: Pipe Maze
// https://adventofcode.com/2023/day/10
// phpcs:ignoreFile

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

$len = strlen( $line[0] );

$map = array();
foreach ( $line as $key => $value ) {
	$map = array_merge( $map, str_split( $value ) );
}

$start       = array_search( 'S', $map );
$alloweddirs = getPossibleMovements( $start );

$paths = array();

$allowed = array(
	'n' => array( 'F', '7', '|' ),
	's' => array( 'J', 'L', '|' ),
	'e' => array( '-', '7', 'J' ),
	'w' => array( 'F', 'L', '-' ),
);

// find starting directions.
foreach ( $alloweddirs as $dir ) {
	$loc = $dir( $start )['pos'];
	if ( in_array( $map[ $loc ], $allowed[ $dir ] ) ) {
		$paths[] = $dir;
	}
}

foreach ( $paths as $dir_to ) {
	if ( ! isset( $cur_positon ) ) {
		$cur_position = $start;

		$data = array(
			'pos'    => $cur_position,
			'dir_to' => $dir_to,
			'char'   => 'S',
		);
	}

	$home = false;
	$step = 0;

	while ( ! $home ) {

		$allowedchars = array( 'F', '7', '|', 'J', 'L', '-', 'S' );

		if ( ! in_array( $data['char'], $allowedchars ) ) {
			echo 'Invalid char ' . $data['char'] . "\n";
			print_r( $data );
			exit;
		}

		$cur_position = $data[ 'pos' ];
		$dir_to       = $data[ 'dir_to' ];

		if ( 'home' === $dir_to ) {
			$home = true;
			$paths['homein'] = $step;
			break;
		}

		$new_position = $dir_to( $cur_position );

		// echo 'New: ' . $new_position['pos'] . ' -> ' . $new_position['dir_to'] . ' Char ' . $new_position['char'] . ' Step: ' . $step . "\n";

		$data = array(
			'pos'    => $new_position['pos'],
			'dir_to' => $new_position['dir_to'],
			'char'   => $new_position['char'],
			'steps'  => $step,
		);

		$step++;
	}
}

echo 'Steps to home: ' . $paths['homein'] . "\n";
echo 'Furthest Point: ' . ceil( $paths['homein'] ) / 2 . "\n";


function n( $cur ) {
	global $len, $map;

	$new_pos = $cur - $len;
	$new_loc = $map[ $new_pos ];

	$dir_to = match ( $new_loc ) {
		'F'     => 'e',
		'7'     => 'w',
		'|'     => 'n',
		'S'     => 'home',
		default => '',
	};

	return array(
		'pos'    => $new_pos,
		'dir_to' => $dir_to,
		'char'   => $new_loc,
	);
}

function s( $cur ) {
	global $len, $map;

	$new_pos = $cur + $len;
	$new_loc = $map[ $new_pos ];

	$dir_to = match ( $new_loc ) {
		'|'     => 's',
		'J'     => 'w',
		'L'     => 'e',
		'S'     => 'home',
		default => '',
	};

	return array(
		'pos'    => $new_pos,
		'dir_to' => $dir_to,
		'char'   => $new_loc,
	);
}

function e( $cur ) {
	global $len, $map;

	$new_pos = $cur + 1;
	$new_loc = $map[ $new_pos ];

	$dir_to = match ( $new_loc ) {
		'-'     => 'e',
		'7'     => 's',
		'J'     => 'n',
		'S'     => 'home',
		default => '',
	};

	return array(
		'pos'    => $new_pos,
		'dir_to' => $dir_to,
		'char'   => $new_loc,
	);
}

function w( $cur ) {
	global $len, $map;

	$new_pos = $cur - 1;
	$new_loc = $map[ $new_pos ];

	$dir_to = match ( $new_loc ) {
		'-'     => 'w',
		'L'     => 'n',
		'F'     => 's',
		'S'     => 'home',
		default => '',
	};

	return array(
		'pos'    => $new_pos,
		'dir_to' => $dir_to,
		'char'   => $new_loc,
	);
}

function getPossibleMovements( $cur ) {
	global $len;

    $directions = [];

    $row = intdiv($cur, $len);
    $col = $cur % $len;

    if ($row > 0) {
        $directions[] = 'n';
    }
    if ($row < $len - 1) {
        $directions[] = 's';
    }
    if ($col > 0) {
        $directions[] = 'w';
    }
    if ($col < $len - 1) {
        $directions[] = 'e';
    }

    return $directions;
}
