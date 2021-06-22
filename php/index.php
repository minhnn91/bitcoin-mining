<?php
include 'hashing.php';
include 'root-merkle.php';

// block 100004

$txids = [
    'ab7ed423933fe5413dc51b1041a58fd8af0cd70491b1ce607cb41dddce74a92b',
    'c763e59a79c9f1e626ddf1c3e9f20f234959c457ff82918f7b24e9d18a12db99',
    '80ea3e647aeef92973f5414e0caa1721c7b42345b99ed161dd505acc41f5516b',
    '1b72eefd70ce0a362ec0cb48e2213274df3c55f9dabd5806cdc087a335498cd3',
    '23e13370f6d59e2d7c7a9ca604b872312de34a387bd7deca2c8f4486f7e66173',
    '149a098d6261b7f9359a572d797c4a41b62378836a14093912618b15644ba402',
];

// render root merkle;
$txidsBEbinary = [];
foreach ($txids as $txidBE) {
    $txidsBEbinary[] = binFlipByteOrder(hex2bin($txidBE));
}
$root = merkleroot($txidsBEbinary);

// 1. Root Merkle - Unchanged
$rootHash = bin2hex(binFlipByteOrder($root));

// 2. Version - Unchanged
$version = 1;

// 3. Prev Block Hash - Unchanged
$prevBlockHash = '000000000002a0a74129007b1481d498d0ff29725e9f403837d517683abac5e1';

// 4. Bits - Unchanged
$bits = 453281356;

// 5. Nonce - Change (1 -> full 32bit)
$nonce = 2731388424;

// 6. Time - Change if Nonce overflows
$time = 1293625358;

// mining block;	
for($t = 1293620000; $t <= $time; $t++) {	
	$hash = hashing($version, $prevBlockHash, $rootHash, $t, $bits, $nonce);
	if ($hash === '000000000000b0b8b4e8105d62300d63c8ec1a1df0af1c2cdbd943b156a8cd79') {
		echo $t, ': <strong style="color: blue;">', $hash, '</strong><br>';
	}
	else {
		echo $t, ': <strong style="color: red;">', $hash, '</strong><br>';
	}
}
?>