<?php
$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

foreach ( $line as $key => $value ) {
	$data    = explode( ' ', $value );
	$hands[] = array(
		'cards' => $data[0],
		'bid'   => $data[1],
	);
}

$ordermap = array( 'J', '2', '3', '4', '5', '6', '7', '8', '9', 'T', 'Q', 'K', 'A' );

function getCardFrequencies( $cards ) {
	return array_count_values( str_split( $cards ) );
}

function assignWildcards( &$frequencies ) {
	if ( isset( $frequencies['J'] ) ) {
		// Number of wildcards
		$wildcards = $frequencies['J'];
		unset( $frequencies['J'] ); // Remove wildcards from frequencies

		while ( $wildcards > 0 ) {
			if ( count( $frequencies ) == 0 ) {
				$frequencies = array( 'J' => 0 );
			}
			// Find the card value with the most occurrences (excluding wildcards)
			$maxValue = max( $frequencies );
			$maxCards = array_keys( $frequencies, $maxValue );
			// In case of a tie, choose the first one (or apply another rule)
			$chosenCard = $maxCards[0];

			// Transform one wildcard into the chosen card value
			++$frequencies[ $chosenCard ];
			--$wildcards;
		}
	}
}

function improveHandRank( $frequencies ) {
	$hand = '';
	foreach ( $frequencies as $key => $value ) {

		$hand .= str_repeat( $key, $value );
	}
	return getHandRank( $hand );
}

$results = array();
foreach ( $hands as $hand ) {
	$cards = $hand['cards'];
	$bid   = $hand['bid'];

	$frequencies = getCardFrequencies( $cards );

	assignWildcards( $frequencies );

	$newrank = improveHandRank( $frequencies );

	$results[] = array(
		'cards'     => $cards,
		'bid'       => $bid,
		'hand_rank' => $newrank,
	);
}

function getCardValue( $card, $ordermap ) {
	return array_search( $card, $ordermap );
}

function compareHands( $hand1, $hand2, $ordermap ) {
	if ( $hand1['hand_rank'] != $hand2['hand_rank'] ) {
		return $hand1['hand_rank'] - $hand2['hand_rank'];
	}

	$cards1 = $hand1['cards'];
	$cards2 = $hand2['cards'];
	for ( $i = 0; $i < min( strlen( $cards1 ), strlen( $cards2 ) ); $i++ ) {
		$value1 = getCardValue( $cards1[ $i ], $ordermap );
		$value2 = getCardValue( $cards2[ $i ], $ordermap );
		if ( $value1 !== $value2 ) {
			return $value2 - $value1; // Descending order
		}
	}

	return $hand1['bid'] - $hand2['bid'];
}

usort(
	$results,
	function ( $hand1, $hand2 ) use ( $ordermap ) {
		return compareHands( $hand1, $hand2, $ordermap );
	}
);

$total_hands = count( $hands );
$total_win   = 0;
foreach ( $results as $key => $result ) {
	$bid        = $result['bid'];
	$cards      = $result['cards'];
	$rank       = $result['hand_rank'];
	$win        = $total_hands * $bid;
	$total_win += $win;
	--$total_hands;
}

function countCharacters( $string ) {
	return array_count_values( str_split( $string ) );
}

function getHandRank( $string ) {

	// total hack!
	if ( 'JJJJJ' == $string ) {
		return 1;
	}

	if ( isFiveOfAKind( $string ) ) {
		return 1;
	}

	if ( isFourOfAKind( $string ) ) {
		return 2;
	}

	if ( isFullHouse( $string ) ) {
		return 3;
	}

	if ( isThreeOfAKind( $string ) ) {
		return 4;
	}

	if ( isTwoPair( $string ) ) {
		return 5;
	}

	if ( isOnePair( $string ) ) {
		return 6;
	}

	if ( isHighCard( $string ) ) {
		return 7;
	}

	return 8;
}


function isFiveOfAKind( $string ) {
	$counts = countCharacters( $string );
	return in_array( 5, $counts );
}

function isFourOfAKind( $string ) {
	$counts = countCharacters( $string );
	return in_array( 4, $counts );
}

function isFullHouse( $string ) {
	$counts = countCharacters( $string );
	return in_array( 3, $counts ) && in_array( 2, $counts );
}

function isThreeOfAKind( $string ) {
	$counts = countCharacters( $string );
	return in_array( 3, $counts ) && count( $counts ) == 3;
}

function isTwoPair( $string ) {
	$counts = countCharacters( $string );
	return count(
		array_filter(
			$counts,
			function ( $count ) {
				return $count == 2;
			}
		)
	) == 2 && count( $counts ) == 3;
}

function isOnePair( $string ) {
	$counts = countCharacters( $string );
	return in_array( 2, $counts ) && count( $counts ) == 4;
}

function isHighCard( $string ) {
	return count( countCharacters( $string ) ) == 5;
}

echo 'Total win: ' . $total_win . PHP_EOL;
