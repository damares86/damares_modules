<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'base_module';
$description = 'Base module template for Damares';
$link_parent = 'base_module';

$prefix = $prefix ?? '';

// Query to create the tables and insert values
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}table_name (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    field VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}second_table_name (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    field VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

// Menu items
$menu_link = [[
    'link' => 'base_module',
    'label' => 'Base module',
    'icon' => 'puzzle',
    'child' => [
        [
            'link' => 'allBaseModule',
            'label' => 'All base module',
            'icon' => 'grid',
            'show_menu' => 1,
        ],
        [
            'link' => 'addBaseModule',
            'label' => 'Add a new base module',
            'icon' => 'plus-circle',
            'show_menu' => 0,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}table_name, {$prefix}second_table_name;";
