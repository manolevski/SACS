<?php  
    $data = $_POST['users'];
    $output = json_encode($data);
    if(isJson($output))
        file_put_contents("../user_data.json", $output);

    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
?>