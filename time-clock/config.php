<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'time-clock';
$description = 'A module for importing employee stampings from xls files';
$link_parent = 'time-clock';

$prefix = $prefix ?? '';

// Query to create the tables and insert values
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}employee (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(190) NOT NULL,
    badge VARCHAR(50) DEFAULT NULL,
    h_mon DECIMAL(4,2) NOT NULL DEFAULT 8.00,
    h_tue DECIMAL(4,2) NOT NULL DEFAULT 8.00,
    h_wed DECIMAL(4,2) NOT NULL DEFAULT 8.00,
    h_thu DECIMAL(4,2) NOT NULL DEFAULT 8.00,
    h_fri DECIMAL(4,2) NOT NULL DEFAULT 8.00,
    active TINYINT(1) NOT NULL DEFAULT 1,
    notes TEXT DEFAULT NULL,
    KEY idx_employee_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}punch (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    employee_id INT(11) NOT NULL,
    punch_date DATE NOT NULL,
    punch_time TIME NOT NULL,
    source VARCHAR(190) DEFAULT NULL,
    UNIQUE KEY uniq_punch (employee_id, punch_date, punch_time),
    KEY idx_punch_date (punch_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'time-clock',
    'label' => 'Time clock',
    'icon' => 'alarm-fill',
    'child' => [
        [
            'link' => 'allEmployees',
            'label' => 'All employees',
            'icon' => 'people-fill',
            'show_menu' => 1,
        ],
        [
            'link' => 'addEmployee',
            'label' => 'Add employee',
            'icon' => 'person-plus-fill',
            'show_menu' => 0,
        ],
        [
            'link' => 'editEmployee',
            'label' => 'Edit employee',
            'icon' => 'pencil-square',
            'show_menu' => 0,
        ],
        [
            'link' => 'importTimbrature',
            'label' => 'Import stamping',
            'icon' => 'person-badge-fill',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}punch, {$prefix}employee;";