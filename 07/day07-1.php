<?php
// Day 7 - Part 1.
// Let's play some cards!

$file = fopen( 'data.txt', 'r' );
if ( ! $file ) {
	exit;
}

$line = array();
while ( ! feof( $file ) ) {
	$line[] = trim( fgets( $file, 1024 ) );
}

foreach ( $line as $key => $value ) {
	$data = explode( ' ', $value );
	$hands[] = array(
		'cards' => $data[0],
		'bid'   => $data[1],
	);
}

$ordermap = array( '2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A' );
$results  = array();
foreach ( $hands as $key => $hand ) {

	$cards = $hand['cards'];
	$bid   = $hand['bid'];

	$results[ $key ] = array(
		'cards' => $cards,
		'bid'   => $bid,
	);

	if ( isFiveOfAKind( $cards ) ) {
		$results[ $key ]['hand_rank'] = 1;
		continue;
	}

	if ( isFourOfAKind( $cards ) ) {
		$results[ $key ]['hand_rank'] = 2;
		continue;
	}

	if ( isFullHouse( $cards ) ) {
		$results[ $key ]['hand_rank'] = 3;
		continue;
	}

	if ( isThreeOfAKind( $cards ) ) {
		$results[ $key ]['hand_rank'] = 4;
		continue;
	}

	if ( isTwoPair( $cards ) ) {
		$results[ $key ]['hand_rank'] = 5;
		continue;
	}

	if ( isOnePair( $cards ) ) {
		$results[ $key ]['hand_rank'] = 6;
		continue;
	}

	if ( isHighCard( $cards ) ) {
		$results[ $key ]['hand_rank'] = 7;
		continue;
	}

	$results[ $key ]['hand_rank'] = 8;
}

function getCardValue($card, $ordermap) {
    return array_search($card, $ordermap);
}

function compareHands($hand1, $hand2, $ordermap) {
    // Compare by hand rank in ascending order
    if ($hand1['hand_rank'] != $hand2['hand_rank']) {
        return $hand1['hand_rank'] - $hand2['hand_rank'];
    }

    // If ranks are equal, compare by card values in descending order using $ordermap
    $cards1 = $hand1['cards'];
    $cards2 = $hand2['cards'];
    for ($i = 0; $i < min(strlen($cards1), strlen($cards2)); $i++) {
        $value1 = getCardValue($cards1[$i], $ordermap);
        $value2 = getCardValue($cards2[$i], $ordermap);
        if ($value1 !== $value2) {
            return $value2 - $value1; // Descending order
        }
    }

    // If all characters are equal, compare by 'bid' or return 0
    return $hand1['bid'] - $hand2['bid'];
}

// Sort the hands
usort($results, function($hand1, $hand2) use ($ordermap) {
    return compareHands($hand1, $hand2, $ordermap);
});

$total_hands = count( $hands );
$total_win   = 0;
foreach ( $results as $key => $result ) {
	$bid = $result['bid'];
	$cards = $result['cards'];
	$rank  = $result['hand_rank'];
	$win = $total_hands * $bid;
	$total_win += $win;
	$total_hands--;
}

echo 'Total win: ' . $total_win . PHP_EOL;

function sortCards( $a, $b ) {
	global $ordermap;

	$pos1 = array_search( $a, $ordermap );
	$pos2 = array_search( $b, $ordermap );

	return $pos1 - $pos2;
}

function sortChars( $string ) {
	$characters = str_split( $string );

	usort( $characters, "sortCards" );

	return implode( '', $characters );
}

function countCharacters($string) {
    return array_count_values(str_split($string));
}

function isFiveOfAKind($string) {
    $counts = countCharacters($string);
    return in_array(5, $counts);
}

function isFourOfAKind($string) {
    $counts = countCharacters($string);
    return in_array(4, $counts);
}

function isFullHouse($string) {
    $counts = countCharacters($string);
    return in_array(3, $counts) && in_array(2, $counts);
}

function isThreeOfAKind($string) {
    $counts = countCharacters($string);
    return in_array(3, $counts) && count($counts) == 3;
}

function isTwoPair($string) {
    $counts = countCharacters($string);
    return count(array_filter($counts, function($count) { return $count == 2; })) == 2 && count($counts) == 3;
}

function isOnePair($string) {
    $counts = countCharacters($string);
    return in_array(2, $counts) && count($counts) == 4;
}

function isHighCard($string) {
    return count(countCharacters($string)) == 5;
}
