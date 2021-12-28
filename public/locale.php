<?php
// with browser set with languaes es-MX, en-CA, en-US
$string = 'es-MX,en-CA;q=0.8,en-US;q=0.5,en;q=0.3';
//substr($this->referringUrl, -5);
$needle = ';';
$position = strpos($string, $needle);
var_dump($position);
$locales = substr($string, 0, $position);
var_dump($locales);

