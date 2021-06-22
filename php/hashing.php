<?php
//This reverses and then swaps every other char
function SwapOrder($in){
  $Split = str_split(strrev($in));
  $x='';
  for ($i = 0; $i < count($Split); $i+=2) {
	  $x .= $Split[$i+1].$Split[$i];
  } 
  return $x;
}

//makes the littleEndian
function littleEndian($value){
  return implode (unpack('H*',pack("V*",$value)));
}

function hashing($version, $prevBlockHash, $rootHash, $time, $bits, $nonce) {
	$version = littleEndian($version);
	$prevBlockHash = SwapOrder($prevBlockHash);
	$rootHash = SwapOrder($rootHash);
	$time = littleEndian($time);
	$bits = littleEndian($bits); 
	$nonce = littleEndian($nonce); 

	//concat it all
	$header_hex = $version . $prevBlockHash . $rootHash . $time . $bits . $nonce;

	//convert from hex to binary 
	$header_bin  = hex2bin($header_hex);
	//hash it then convert from hex to binary 
	$pass1 = hex2bin(  hash('sha256', $header_bin )  );
	//Hash it for the seconded time
	$pass2 = hash('sha256', $pass1);
	//fix the order
	$FinalHash = SwapOrder($pass2);
	return  $FinalHash;
}