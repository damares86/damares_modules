<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'questions';
$description = 'Post questions during a session';
$link_parent = 'questions';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}questions (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    session_id INT(5) NOT NULL,
    account_id INT(5) NOT NULL,
    question TEXT DEFAULT NULL,
    approved INT(1) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'questions',
    'label' => 'Questions',
    'icon' => 'question-square',
    'child' => [
        [
            'link' => 'allQuestions',
            'label' => 'All Questions',
            'icon' => 'question-square',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}questions;";