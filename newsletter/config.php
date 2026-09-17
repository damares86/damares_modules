<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'newsletter';
$description = 'A basic newsletter manager';
$link_parent = 'newsletter';

$prefix = $prefix ?? '';

// Query to create the tables and insert values
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}newsletter_subscribers (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) DEFAULT NULL,
    subscribed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    confirmed TINYINT(1) DEFAULT 1
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}newsletter_messages (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL UNIQUE,
    body LONGTEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status TINYINT(1) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}newsletter_queue (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    subscriber_id INT(5) NOT NULL,
    message_id INT(11) NOT NULL,
    status ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    sent_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_sub_msg (subscriber_id, message_id),
    FOREIGN KEY (subscriber_id) REFERENCES {$prefix}newsletter_subscribers(id) ON DELETE CASCADE,
    FOREIGN KEY (message_id) REFERENCES {$prefix}newsletter_messages(id) ON DELETE CASCADE
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}newsletter_settings (
    id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    value LONGTEXT NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO {$prefix}newsletter_settings (name, value)
VALUES ('confirmation', '0'),
       ('email', 'test@mail.com'),
       ('password', 'test'),
       ('name', 'Newsletter'),
       ('host', 'mail.site.com'),
       ('secure', 'ssl'),
       ('port', '465')
ON DUPLICATE KEY UPDATE value = VALUES(value);";

$menu_link = [[
    'link' => 'newsletter',
    'label' => 'Newsletter',
    'icon' => 'envelope-check-fill',
    'child' => [
        [
            'link' => 'addEmail',
            'label' => 'Create a new email',
            'icon' => 'envelope-plus-fill',
            'show_menu' => 0,
        ],
        [
            'link' => 'editEmail',
            'label' => 'Edit an email',
            'icon' => 'envelope-open-fill',
            'show_menu' => 0,
        ],
        [
            'link' => 'allEmails',
            'label' => 'All email',
            'icon' => 'envelope-fill',
            'show_menu' => 1,
        ],
        [
            'link' => 'allSubscribers',
            'label' => 'Manage subscribers',
            'icon' => 'people-fill',
            'show_menu' => 1,
        ],
        [
            'link' => 'addSubscriber',
            'label' => 'Add subscriber',
            'icon' => 'person-plus-fill',
            'show_menu' => 0,
        ],
        [
            'link' => 'editSubscriber',
            'label' => 'Edit subscriber',
            'icon' => 'person-fill',
            'show_menu' => 0,
        ],
        [
            'link' => 'allNewsletterSettings',
            'label' => 'Newsletter Settings',
            'icon' => 'gear-fill',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}newsletter_queue, {$prefix}newsletter_messages, {$prefix}newsletter_subscribers, {$prefix}newsletter_settings;";
