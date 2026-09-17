<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'customers';
$description = 'Create and manage customers';
$link_parent = 'customers';

$prefix = $prefix ?? '';

// Query to create and drop the table
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}customers (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'customers',
    'label' => 'Customers',
    'icon' => 'person-vcard',
    'child' => [
        [
            'link' => 'allCustomers',
            'label' => 'All Customers',
            'icon' => 'people-fill',
            'show_menu' => 1,
        ],
        [
            'link' => 'addCustomer',
            'label' => 'Add a customer',
            'icon' => 'person-plus-fill',
            'show_menu' => 1,
        ],
        [
            'link' => 'editCustomer',
            'label' => 'Edit a customer',
            'icon' => 'person-plus-fill',
            'show_menu' => 0,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}customers;";
