<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$source = "https://www.guitarbackingtrack.com/content/stream?id=1065&hash=f2fb6f30f0f8057de26d0688f6617d15";
$userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';

$ch = curl_init( );
curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
curl_setopt($ch, CURLOPT_URL, $source);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_SSLVERSION,3);
$data = curl_exec ($ch);
$error = curl_error($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($data, 0, $header_size);
curl_close ($ch);
echo($error);
echo $data;

$destination = "/tmp/test.mp3";
$file = fopen($destination, "w+");
fputs($file, $data);
fclose($file);
