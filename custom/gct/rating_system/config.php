<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'rating_system';
$description = 'Add a rating system for files, users or other items';
$link_parent = 'rating';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}rate_cat (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(255) NOT NULL,
    active INT(1) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}item_rate (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    rate_cat_id INT(5) NOT NULL,
    item_id INT(5) NOT NULL,
    rate_active INT(1) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}rate (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    item_rate_id INT(5) NOT NULL,
    vote_sum INT(5) DEFAULT 0,
    vote_number INT(5) DEFAULT 0,
    star TEXT DEFAULT NULL,
    star_vote FLOAT(3,1) DEFAULT 0,
    percent INT(5) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'rating',
    'label' => 'Rating',
    'icon' => 'stars',
    'child' => [
        [
            'link' => 'allRate',
            'label' => 'Rate results',
            'icon' => 'star-half',
            'show_menu' => 1,
        ],
        [
            'link' => 'editRateItems',
            'label' => 'Manage rate items',
            'icon' => 'file-check',
            'show_menu' => 1,
        ],
        [
            'link' => 'editRateCat',
            'label' => 'Manage rate categories',
            'icon' => 'card-checklist',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}rate, {$prefix}item_rate, {$prefix}rate_cat;";