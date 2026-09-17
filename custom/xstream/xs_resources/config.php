<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'xs_resources';
$description = 'Manage XStream Resources';
$link_parent = 'xs_resources';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}resources (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    resource_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    product_id INT(5) NOT NULL,
    lang_id INT(5) NOT NULL,
    type_id INT(5) NOT NULL,
    resource_date DATE DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}resource_lang (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    resource_lang VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}resource_type (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    resource_type VARCHAR(255) NOT NULL,
    img VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'xs_resources',
    'label' => 'Resources',
    'icon' => 'file-earmark-pdf',
    'child' => [
        [
            'link' => 'allXSResources',
            'label' => 'All resources',
            'icon' => 'files',
            'show_menu' => 1,
        ],
        [
            'link' => 'allXSLangs',
            'label' => 'Resources language',
            'icon' => 'translate',
            'show_menu' => 1,
        ],
        [
            'link' => 'allXSTypes',
            'label' => 'Resources type',
            'icon' => 'bookmarks',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}resources, {$prefix}resource_lang, {$prefix}resource_type;";