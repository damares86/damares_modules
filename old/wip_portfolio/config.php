<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'portfolio';
$description = 'It creates a portfolio and manages your projects.';
$link_parent = 'portfolio';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}portfolio (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    project_title VARCHAR(255) NOT NULL,
    main_img VARCHAR(255) NOT NULL DEFAULT 'visual.jpg',
    description TEXT NOT NULL,
    client VARCHAR(255) NOT NULL,
    completed DATE NOT NULL,
    category TEXT DEFAULT NULL,
    link VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}portfolio_categories (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO {$prefix}portfolio_categories (id, category_name)
VALUES (1, 'Misc')
ON DUPLICATE KEY UPDATE category_name = VALUES(category_name);";

$menu_link = [[
    'link' => 'portfolio',
    'label' => 'Portfolio',
    'icon' => 'image',
    'child' => [
        [
            'link' => 'allPortfolio',
            'label' => 'All projects',
            'icon' => 'images',
            'show_menu' => 1,
        ],
        [
            'link' => 'addPortfolio',
            'label' => 'Add a project',
            'icon' => 'patch-plus',
            'show_menu' => 1,
        ],
        [
            'link' => 'addCatPortfolio',
            'label' => 'All categories',
            'icon' => 'tag',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}portfolio, {$prefix}portfolio_categories;";