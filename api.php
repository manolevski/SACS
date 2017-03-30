<?php
 
$token= $_GET['token']; 

$string = file_get_contents("user_data.json");
$json = json_decode($string, true); // decode the JSON into an associative array

foreach ($json as $field) {
  if($field['token'] == $token)
    echo json_encode($field);
}
?>