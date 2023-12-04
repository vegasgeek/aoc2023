<?php
// Day 3 - Part 1.
// It's a symbol.

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

foreach ( $line as $key => $value ) {
	$len     = strlen( $value );
	$pos     = 0;
	$numbers = array();
	$symbols = array();
	while ( $pos < $len ) {
		$char = substr( $value, $pos, 1 );
		if ( '.' === $char ) {
			$pos++;
			continue;
		}
		if ( is_numeric( $char ) ) {
			$num = $char;
			$pos++;
			while ( is_numeric( substr( $value, $pos, 1 ) ) ) {
				$num .= substr( $value, $pos, 1 );
				$pos++;
			}
			$numbers[] = array(
				'uuid'   => make_uuid(),
				'number' => $num,
				'pos'    => $pos - strlen( $num ),
				'length' => strlen( $num ),
			);
			continue;
		}
		$symbols[] = array(
			'pos' => $pos,
		);
		$pos++;
	}

	$line[ $key ] = array(
		'numbers' => $numbers,
		'symbols' => $symbols,
	);
}
fclose( $file );

$used_parts = array();
$total      = 0;

// Look at line below.
foreach ( $line as $key => $val ) {
	$test_line = $key + 1;
	if ( ! isset( $line[ $test_line ] ) ) {
		continue;
	}

	// loop through each symbol on a line.
	foreach ( $val['symbols'] as $symbol ) {
		$pos = $symbol['pos'];
		// loop through each number on the next line.
		foreach ( $line[ $test_line ]['numbers'] as $test_num ) {
			$pos_start = $test_num['pos'] - 1;
			$pos_end   = $test_num['pos'] + $test_num['length'];

			if ( $pos >= $pos_start && $pos <= $pos_end ) {
				$used_parts[] = array(
					'uuid' => $test_num['uuid'],
				);

				$total += $test_num['number'];
			}
		}
	}
}

// Look at line above.
foreach ( $line as $key => $val ) {
	$test_line = $key - 1;

	// loop through each symbol on a line.
	foreach ( $val['symbols'] as $symbol ) {
		$pos = $symbol['pos'];
		if ( $test_line < 0 ) {
			continue;
		}
		// loop through each number on the next line.
		foreach ( $line[ $test_line ]['numbers'] as $test_num ) {
			$pos_start = $test_num['pos'] - 1;
			$pos_end   = $test_num['pos'] + $test_num['length'];

			if ( $pos >= $pos_start && $pos <= $pos_end ) {
				if ( ! in_array( $test_num['uuid'], $used_parts ) ) {
					$used_parts[] = array(
						'uuid' => $test_num['uuid'],
					);

					$total += $test_num['number'];
				}
			}
		}
	}
}

// Look at same line.
foreach ( $line as $key => $val ) {
	$test_line = $key;

	// loop through each symbol on a line.
	foreach ( $val['symbols'] as $symbol ) {
		$pos = $symbol['pos'];
		if ( $test_line < 0 ) {
			continue;
		}
		// loop through each number on the next line.
		foreach ( $line[ $test_line ]['numbers'] as $test_num ) {
			$pos_start = $test_num['pos'] - 1;
			$pos_end   = $test_num['pos'] + $test_num['length'];

			if ( $pos >= $pos_start && $pos <= $pos_end ) {
				if ( ! in_array( $test_num['uuid'], $used_parts ) ) {
					$used_parts[] = array(
						'uuid' => $test_num['uuid'],
					);

					$total += $test_num['number'];
				}
			}
		}
	}
}

echo $total;

function make_uuid() {
	$s = strtoupper( md5( uniqid( rand(), true ) ) );
	$uuid = substr( $s, 0, 8 ) . '-' .
		substr( $s, 8, 4 ) . '-' .
		substr( $s, 12, 4 ) . '-' .
		substr( $s, 16, 4 ) . '-' .
		substr( $s, 20 );
	return $uuid;
}
