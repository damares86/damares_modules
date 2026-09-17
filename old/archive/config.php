<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'archive';
$description = 'Archive';
$link_parent = 'archive';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}archive_files (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    archive_year_id INT(5) NOT NULL,
    month INT(5) DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}archive_years (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    year INT(4) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'archive',
    'label' => 'Archive',
    'icon' => 'newspaper',
    'child' => [
        [
            'link' => 'allArchive',
            'label' => 'All archive files',
            'icon' => 'newspaper',
            'show_menu' => 1,
        ],
        [
            'link' => 'addArchive',
            'label' => 'Add a new archive file',
            'icon' => 'plus-circle',
            'show_menu' => 0,
        ],
        [
            'link' => 'editArchive',
            'label' => 'Edit an archive file',
            'icon' => 'pencil',
            'show_menu' => 0,
        ],
        [
            'link' => 'allArchiveYear',
            'label' => 'Archive years',
            'icon' => 'calendar-date',
            'show_menu' => 1,
        ],
        [
            'link' => 'addArchiveYear',
            'label' => 'Add an archive year',
            'icon' => 'calendar-date',
            'show_menu' => 0,
        ],
        [
            'link' => 'editArchiveYear',
            'label' => 'Edit an archive year',
            'icon' => 'calendar-date',
            'show_menu' => 0,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}archive_files, {$prefix}archive_years;";
