#!/opt/homebrew/bin/php
<?php

require 'vendor/autoload.php';


$search = isset($argv[1]) ? $argv[1] : null;

[$type, $id] = explode('.', $search);
$actions = [];

if ($type === 'automation') {
    $actions[] = [
        'uid' => $type,
        'autocomplete' => $type,
        'type' => 'file',
        'arg' => [$search, 'automation/trigger'],
        'icon' => [
            'path' => 'automation.png',
        ],
        'title' => 'Trigger automation',
    ];
}

if ($type === 'switch') {
    $actions[] = [
        'uid' => $type,
        'autocomplete' => $type,
        'type' => 'file',
        'arg' => [$search, 'switch/toggle'],
        'icon' => [
            'path' => 'switch.png',
        ],
        'title' => 'Toggle switch',
    ];
}

echo json_encode(['items' => $actions]);