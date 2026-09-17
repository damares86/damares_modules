<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'rsa';
$description = 'Gestione Ordini Farmaci RSA';
$link_parent = 'rsa';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}pazienti (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cognome VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}farmaci (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    principio VARCHAR(255) NOT NULL,
    cpr_box INT(10) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}pazienti_farmaci (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_pazienti INT(10) NOT NULL,
    id_farmaci INT(10) NOT NULL,
    cpr FLOAT NOT NULL,
    magazzino INT(10) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'rsa',
    'label' => 'RSA',
    'icon' => 'hospital',
    'child' => [
        [
            'link' => 'allPazienti',
            'label' => 'Pazienti',
            'icon' => 'person-vcard',
            'show_menu' => 1,
        ],
        [
            'link' => 'allFarmaci',
            'label' => 'Elenco farmaci',
            'icon' => 'capsule',
            'show_menu' => 1,
        ],
        [
            'link' => 'addOrdini',
            'label' => 'Calcola un ordine',
            'icon' => 'box-seam',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}pazienti_farmaci, {$prefix}farmaci, {$prefix}pazienti;";
