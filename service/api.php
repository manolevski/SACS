<?php
 
$token= $_GET['token']; 
$key = 'SuperSecretKey13';
$iv = "45287112549354892144548565456541";

$string = file_get_contents("user_data.json");
$json = json_decode($string, true); // decode the JSON into an associative array

foreach ($json as $field) {
  if($field['token'] == $token){
	$text = json_encode($field);
	$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
	$padding = $block - (strlen($text) % $block);
	$text .= str_repeat(chr($padding), $padding);
	
	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_CBC, $iv);
	$crypttext64=base64_encode($crypttext);
	  
    echo $crypttext64;
  }
}
?>