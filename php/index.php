<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>SIN GENERATOR</title>
</head>
<body>
<ul>	
<?php
/*
FNG Canada Social Insurance Number Generator and Validator v1.1
Copyright © 2009 Fake Name Generator <http://www.fakenamegenerator.com/>
FNG Canada Social Insurance Number Generator and Validator v1.1 by the Fake 
Name Generator is licensed to you under a Creative Commons Attribution-Share 
Alike 3.0 United States License.
For full license details, please visit:
http://www.fakenamegenerator.com/license.php
*/
class fngsin{
	// Validates using the Luhn Algorithm (MOD10)
	// See: http://en.wikipedia.org/wiki/Luhn_algorithm
	function luhn($str){
		$odd = !strlen($str)%2;
		$sum = 0;
		for($i=0;$i<strlen($str);++$i){
			$n=0+$str[$i];
			$odd=!$odd;
			if($odd){
				$sum+=$n;
			}else{
				$x=2*$n;
				$sum+=$x>9?$x-9:$x;
			}
		}
		return(($sum%10)==0);
	}
	function validateSIN($sin){
		$sin = preg_replace('/[^0-9]/','',$sin);
		if(strlen($sin) == 9){
			if($sin[0] == '0' || $sin[0] == '8'){
				return false;
			}else{
				return $this->luhn($sin);
			}
		}else{
			return false;
		}
	}
	function generateSIN($separator = ''){
		$validPrefix = array(1,2,3,4,5,6,7,9);
		$sin = array_rand($validPrefix,1);
		$length = 9;
		while(strlen($sin) < ($length - 1)){
			$sin .= rand(1,9);
		}
		$sum = 0;
		$pos = 0;
		$reversedSIN = strrev( $sin );
		while($pos < $length - 1){
			$odd = $reversedSIN[ $pos ] * 2;
			if($odd > 9){
				$odd -= 9;
			}
			$sum += $odd;
			if($pos != ($length - 2)){
				$sum += $reversedSIN[ $pos +1 ];
			}
			$pos += 2;
		}
		$checkdigit = (( floor($sum/10) + 1) * 10 - $sum) % 10;
		$sin .= $checkdigit;
		// $sin1 = substr($sin,0,3);
		// $sin2 = substr($sin,3,3);
		// $sin3 = substr($sin,6,3);
		// return $sin1.$separator.$sin2.$separator.$sin3;
		return $sin;
	}
	
}

// Instantiate the class
$fngsin = new fngsin();

$i = 1;
while ($i <= 1000) {
	?>
	
	<div>
	<?php
	// Generate a SIN
	$print_sin = $fngsin->generateSIN();

	if ($print_sin[0] !== '0') {
		echo $i . "/" .  $print_sin;
		$i++;
	}
	?>
	</div>

	<?php
}
// Validate a SIN
// echo $fngsin->validateSIN('046 454 286');
?>
</ul>
</body>
</html>