<?php
 
$token= $_GET['token']; 
$key = 'SuperSecretKey13';

$string = file_get_contents("user_data.json");
$json = json_decode($string, true); // decode the JSON into an associative array

foreach ($json as $field) {
  if($field['token'] == $token)
    echo mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, json_encode($field), MCRYPT_MODE_ECB);
}
?>