<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'sessions';
$description = 'Create and manage sessions and speakers in conventions';
$link_parent = 'sessions';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}sessions (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sessions_name VARCHAR(255) NOT NULL,
    location_id INT(5) NOT NULL,
    date DATETIME NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    people_id TEXT NOT NULL,
    relations_id TEXT NOT NULL,
    active INT(5) DEFAULT 0,
    question_active INT(5) DEFAULT 0,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}location (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    location_name VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}people (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    people_name VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default.png',
    description TEXT DEFAULT NULL,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}people_cat (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    people_cat_name VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}people_cat_id (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    people_id INT(5) NOT NULL,
    cat_id INT(5) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO {$prefix}people_cat (id, people_cat_name)
VALUES (1, 'Chairperson'),
       (2, 'Expert'),
       (3, 'Announcer')
ON DUPLICATE KEY UPDATE people_cat_name = VALUES(people_cat_name);";

$menu_link = [[
    'link' => 'sessions',
    'label' => 'Sessions',
    'icon' => 'person-video3',
    'child' => [
        [
            'link' => 'allSessions',
            'label' => 'All sessions',
            'icon' => 'window-dock',
            'show_menu' => 1,
        ],
        [
            'link' => 'addSession',
            'label' => 'Add a new session',
            'icon' => 'window-plus',
            'show_menu' => 1,
        ],
        [
            'link' => 'allPeople',
            'label' => 'All announcers',
            'icon' => 'person-vcard',
            'show_menu' => 1,
        ],
        [
            'link' => 'addPeople',
            'label' => 'Add a new announcer',
            'icon' => 'person-plus-fill',
            'show_menu' => 1,
        ],
        [
            'link' => 'allLocations',
            'label' => 'All locations',
            'icon' => 'pin-map-fill',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}people_cat_id, {$prefix}people_cat, {$prefix}people, {$prefix}location, {$prefix}sessions;";