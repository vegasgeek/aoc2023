<?php
// Day 4 - Part 1.
// Scratch and Win!

$file = fopen( 'data-test.txt', 'r' );
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

	// remove any array elements that are non-numeric.
	$winners        = array_filter( $winners, 'is_numeric' );
	$numbers        = array_filter( $numbers, 'is_numeric' );
	$matches        = array_intersect( $winners, $numbers );
	$cards[ $card ] = count( $matches );

	$copies[ $card ]      = 0;
	$total_cards[ $card ] = 1;
}

// making copies!
foreach ( $cards as $card => $matches ) {
	echo '----- Start card ' . $card . ' -----' . "\n";
	$next_card = $card + 1;

	if ( $matches > 0 ) {
		$loop = $matches;
		echo 'Card ' . $card . ' has ' . $matches . ' matches.' . "\n";
		while ( $loop > 0 ) {
			$copies[ $next_card ]      = $copies[ $next_card ] + 1;
			$total_cards[ $next_card ] = $total_cards[ $next_card ] + 1;
			$loop--;
			$next_card++;
		}
	}

	echo '------ Start copies ' . $card .' ------' . "\n";
	if ( $copies[ $card ] > 0 && $matches > 0 ) {
		$loop = $copies[ $card ];
		echo 'Card ' . $card . ' has ' . $copies[ $card ] . ' copies.' . "\n";
		$next_card = $card + 1;

		while ( $loop > 0 ) {
			while ( $matches > 0 ) {
				$copies[ $next_card ] = $copies[ $next_card ] + 1;
				$total_cards[ $next_card ] = $total_cards[ $next_card ] + 1;
				$matches--;
				$next_card++;
			}
			$loop--;
		}
	}
}

print_r( $copies );


// print_r( $total_cards );
// print_r( $copies );
// echo $total_tickets . "\n";

/**

1 . 1
2 .. 2
3 .... 4
4 ........ 8
5 .............. 14
6 . 1

 */