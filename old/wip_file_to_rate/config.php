<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'file_to_rate';
$description = 'Add files to be rated by users';
$link_parent = 'fileRate';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}rate_cat (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}file_cat (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    file_id INT(5) NOT NULL,
    rate_cat_id INT(5) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}file_account_rate (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    account_id INT(5) NOT NULL,
    file_id INT(5) NOT NULL,
    rate INT(1) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}rate (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    file_id INT(5) NOT NULL,
    vote_sum INT(11) NOT NULL DEFAULT 0,
    vote_number INT(5) NOT NULL DEFAULT 0,
    star INT(3) NOT NULL DEFAULT 0,
    percent INT(3) NOT NULL DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'fileRate',
    'label' => 'File to rate',
    'icon' => 'star-fill',
    'child' => [
        [
            'link' => 'allFilesRate',
            'label' => 'All files to rate',
            'icon' => 'files-alt',
            'show_menu' => 1,
        ],
        [
            'link' => 'addFileRate',
            'label' => 'Add file to rate',
            'icon' => 'file-earmark-plus',
            'show_menu' => 1,
        ],
        [
            'link' => 'allCatRate',
            'label' => 'Rate categories',
            'icon' => 'grid-fill',
            'show_menu' => 1,
        ],
        [
            'link' => 'addCatRate',
            'label' => 'Add rate category',
            'icon' => 'plus-square-fill',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}rate, {$prefix}file_account_rate, {$prefix}file_cat, {$prefix}rate_cat;";