#!/opt/homebrew/bin/php
<?php

require 'vendor/autoload.php';

$api = new \HomeassistantAlfred\Api();
$states = $api->get('/api/states');

$states = array_filter($states, function ($state) {
    return str_starts_with($state['entity_id'], 'switch.') || str_starts_with($state['entity_id'], 'automation.');
});

$states = array_map(function ($state) {
    [$type] = explode('.', $state['entity_id']);


    return [
        'uid' => $state['entity_id'],
        'autocomplete' => $state['entity_id'],
        'subtitle' => $state['entity_id'] . ' - ' . $state['state'],
        'arg' => $state['entity_id'],
        'icon' => [
            'path' => $type . '.png',
        ],
        'title' => $state['attributes']['friendly_name'],
    ];
}, $states);


$search = isset($argv[1]) ? $argv[1] : null;

if ($search) {
    $states = array_values(array_filter($states, function ($state) use ($search) {
        $tmp = explode(' ', $search);
        foreach ($tmp as $part) {
            if (str_contains(strtolower($state['uid']), strtolower($part))) {
                return true;
            }
        }

        return false;
    }));
}

echo json_encode(['items' => $states]);