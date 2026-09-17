<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'quiz';
$description = 'Create and manage quiz with variable number of questions and score management';
$link_parent = 'quiz';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}quiz (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quiz_name VARCHAR(255) NOT NULL,
    counter INT(2) NOT NULL,
    active INT(1) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}quiz_scores (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT(5) NOT NULL,
    winner_id INT(5) DEFAULT NULL,
    answer TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}quiz_relation (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT(5) NOT NULL,
    relation_id INT(5) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'quiz',
    'label' => 'Quiz',
    'icon' => 'trophy-fill',
    'child' => [
        [
            'link' => 'allQuiz',
            'label' => 'All quiz',
            'icon' => 'patch-question',
            'show_menu' => 1,
        ],
        [
            'link' => 'addQuiz',
            'label' => 'Add a new quiz',
            'icon' => 'patch-plus',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}quiz_relation, {$prefix}quiz_scores, {$prefix}quiz;";
