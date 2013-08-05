<?php
require "Ping.php";

/**
* Ping calling
*/
$email  = "test@test.it";
$url    = "http://www.google.com";

$ping = new Ping($email);
$ping->checkUrl($url);