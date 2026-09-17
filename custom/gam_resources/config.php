<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'gam_resources';
$description = 'Manage GAM Resources (prayers, song, etc)';
$link_parent = 'gam_resources';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}resources (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    resource_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    cat_id INT(5) NOT NULL,
    type_id INT(5) NOT NULL,
    img VARCHAR(255) DEFAULT 'default_res.png',
    resource_date DATE DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}resource_cat (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cat VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}resource_type (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'gam_resources',
    'label' => 'GAM Resources',
    'icon' => 'book',
    'child' => [
        [
            'link' => 'allGamResources',
            'label' => 'All Gam Resources',
            'icon' => 'file-earmark-pdf',
            'show_menu' => 1,
        ],
        [
            'link' => 'allGamCats',
            'label' => 'Resources category',
            'icon' => 'file',
            'show_menu' => 1,
        ],
        [
            'link' => 'allGamTypes',
            'label' => 'Resources type',
            'icon' => 'bookmarks',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}resources, {$prefix}resource_cat, {$prefix}resource_type;";