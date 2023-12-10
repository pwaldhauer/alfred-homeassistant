#!/opt/homebrew/bin/php
<?php

require 'vendor/autoload.php';

$api = new \HomeassistantAlfred\Api();

$search = isset($argv[1]) ? $argv[1] : null;


$api->post('/api/services/' . $argv[2], [
    'entity_id' => $search,
]);