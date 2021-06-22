<?php

function binFlipByteOrder($string) {
    return implode('', array_reverse(str_split($string, 1)));
}

function merkleroot($txids) {

    // Check for when the result is ready, otherwise recursion
    if (count($txids) === 1) {
        return $txids[0];
    }

    // Calculate the next row of hashes
    $pairhashes = [];
    while (count($txids) > 0) {
        if (count($txids) >= 2) {
            // Get first two
            $pair_first = $txids[0];
            $pair_second = $txids[1];

            // Hash them
            $pair = $pair_first.$pair_second;
            $pairhashes[] = hash('sha256', hash('sha256', $pair, true), true);

            // Remove those two from the array
            unset($txids[0]);
            unset($txids[1]);

            // Re-set the indexes (the above just nullifies the values) and make a new array without the original first two slots.
            $txids = array_values($txids);
        }

        if (count($txids) == 1) {
            // Get the first one twice
            $pair_first = $txids[0];
            $pair_second = $txids[0];

            // Hash it with itself
            $pair = $pair_first.$pair_second;
            $pairhashes[] = hash('sha256', hash('sha256', $pair, true), true);

            // Remove it from the array
            unset($txids[0]);

            // Re-set the indexes (the above just nullifies the values) and make a new array without the original first two slots.
            $txids = array_values($txids);
        }
    }

    return merkleroot($pairhashes);
}