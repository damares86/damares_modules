<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'post';
$description = 'Manage a blog, with custom categories';
$link_parent = 'post';

$prefix = $prefix ?? '';

// Query to create and drop the table
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}post (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    main_img VARCHAR(255) DEFAULT NULL,
    gall VARCHAR(255) DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    author INT(5) NOT NULL,
    content LONGTEXT NOT NULL,
    created DATETIME NOT NULL,
    category_id VARCHAR(255) DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}post_categories (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL,
    assign_page INT(5) DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO {$prefix}post_categories (id, category_name)
VALUES (1, 'Misc')
ON DUPLICATE KEY UPDATE category_name = VALUES(category_name);";

$menu_link = [[
    'link' => 'post',
    'label' => 'Blog',
    'icon' => 'vector-pen',
    'child' => [
        [
            'link' => 'addPost',
            'label' => 'Add post',
            'icon' => 'file-earmark-plus',
            'show_menu' => 1,
        ],
        [
            'link' => 'allPosts',
            'label' => 'All Posts',
            'icon' => 'file-earmark-post',
            'show_menu' => 1,
        ],
        [
            'link' => 'allPostsCat',
            'label' => 'All categories',
            'icon' => 'bookmarks',
            'show_menu' => 1,
        ],
        [
            'link' => 'addPostCat',
            'label' => 'Add post cat',
            'icon' => 'plus-circle',
            'show_menu' => 0,
        ],
        [
            'link' => 'editPostCat',
            'label' => 'Edit post cat',
            'icon' => 'pencil',
            'show_menu' => 0,
        ],
        [
            'link' => 'editPost',
            'label' => 'Edit post',
            'icon' => 'pencil',
            'show_menu' => 0,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}post, {$prefix}post_categories;";
