<?php

$configFile = file_get_contents("config.json");
$config = json_decode($configFile, true);

function getUrl($url){
    $session = curl_init($url); 
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($session, CURLOPT_USERAGENT, true); 
    $apiResponse = curl_exec($session);
    $jsonResponse = json_decode($apiResponse, true);
    curl_close($session);
    return $jsonResponse;
};


$link = "https://github.com/". $config["username"]. "/". $config["repositoryName"]. "/archive/refs/heads/main.zip";
$file = file_put_contents("repository.zip", file_get_contents($link));
$zip = new ZipArchive;

$zip -> open("repository.zip");
$zip -> extractTo(".");
$zip -> close();
unlink("repository.zip");