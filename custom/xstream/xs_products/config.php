<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'xs_products';
$description = 'Manage XStream Products';
$link_parent = 'xs_products';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}product (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}product_files (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_files_name VARCHAR(255) NOT NULL,
    product_files_label VARCHAR(255) NOT NULL,
    product_files_cat_id INT(5) NOT NULL,
    product_id INT(5) NOT NULL,
    permissions TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}product_files_cat (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}product_permissions (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customers_id INT(5) NOT NULL,
    product_id INT(5) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'xs_products',
    'label' => 'Products',
    'icon' => 'display',
    'child' => [
        [
            'link' => 'allXSProduct',
            'label' => 'All products',
            'icon' => 'display',
            'show_menu' => 1,
        ],
        [
            'link' => 'allXSProductCat',
            'label' => 'Files categories',
            'icon' => 'bookmarks',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}product_permissions, {$prefix}product_files, {$prefix}product_files_cat, {$prefix}product;";