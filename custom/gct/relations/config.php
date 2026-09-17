<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'relations';
$description = 'Create and manage relations and speakers in conventions';
$link_parent = 'relations';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}relations (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    relations_name VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    location INT(5) NOT NULL,
    speakers_id TEXT NOT NULL,
    announcer_id TEXT DEFAULT NULL,
    active INT(5) DEFAULT 0,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}speakers (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    speakers_name VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default.png',
    description TEXT DEFAULT NULL,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}speakers_doc (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    speakers_doc_name VARCHAR(255) NOT NULL,
    label VARCHAR(255) NOT NULL,
    speaker_id INT(5) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}relations_speakers_doc (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    relation_id INT(5) NOT NULL,
    speaker_id INT(5) NOT NULL,
    speaker_doc_id INT(5) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'relations',
    'label' => 'Relations',
    'icon' => 'person-video3',
    'child' => [
        [
            'link' => 'allRelations',
            'label' => 'All relations',
            'icon' => 'window-fullscreen',
            'show_menu' => 1,
        ],
        [
            'link' => 'addRelation',
            'label' => 'Add a relation',
            'icon' => 'window-plus',
            'show_menu' => 1,
        ],
        [
            'link' => 'allSpeakers',
            'label' => 'All speakers',
            'icon' => 'person-vcard',
            'show_menu' => 1,
        ],
        [
            'link' => 'addSpeaker',
            'label' => 'Add a new speaker',
            'icon' => 'person-plus-fill',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}relations_speakers_doc, {$prefix}speakers_doc, {$prefix}speakers, {$prefix}relations;";