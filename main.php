<?php

function getUrl($url){
    $session = curl_init($url); 
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true); 
    $apiResponse = curl_exec($session);
    curl_close($session);
    return $apiResponse;
};

$configFile = file_get_contents("config.json");
$config = json_decode($configFile, true);