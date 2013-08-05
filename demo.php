<?php
require "Ping.php";

/**
* Ping calling
*/
$email  = "marco.troisi@dubbleup.com";
$url    = "http://www.marcotroisi.com";

$ping = new Ping($email);
$ping->checkUrl($url);