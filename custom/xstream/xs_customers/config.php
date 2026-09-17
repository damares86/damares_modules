<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'xs_customers';
$description = 'Create and manage XStream customers';
$link_parent = 'xs_customers';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}customers (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL,
    auth_token VARCHAR(255) DEFAULT 'none',
    last_login DATETIME DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'xs_customers',
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
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}customers;";