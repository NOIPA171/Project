<?php

$url = 'sidemenu.json';
$data = file_get_contents($url);
echo "<pre>";
print_r(json_decode($data));
echo "</pre>";
