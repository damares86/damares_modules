<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'cfa';
$description = 'CFA Manager';
$link_parent = 'cfa';

$prefix = $prefix ?? '';

// Query to create and drop the tables
$query_create_table = "CREATE TABLE IF NOT EXISTS {$prefix}collaboratori (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cognome VARCHAR(255) NOT NULL,
    sede_legale VARCHAR(255) NOT NULL,
    sede_operativa VARCHAR(255) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    cellulare VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    pec VARCHAR(255) NOT NULL,
    codice_fiscale VARCHAR(255) NOT NULL,
    p_iva VARCHAR(255) NOT NULL,
    ritenuta_acconto INT(10) NOT NULL,
    iban VARCHAR(27) NOT NULL,
    banca VARCHAR(255) NOT NULL,
    iscrizione_rui VARCHAR(255) NOT NULL,
    consulenza_collab INT(10) NOT NULL,
    premio_collab INT(10) NOT NULL,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}compagnie (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    sede_legale VARCHAR(255) NOT NULL,
    p_iva VARCHAR(50) NOT NULL,
    provv INT(10) NOT NULL,
    ritenuta_acconto INT(5) DEFAULT 0,
    provv_calcolate_su INT(1) DEFAULT 0,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}contraente (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ragione_sociale_contraente VARCHAR(255) NOT NULL,
    nome_contraente VARCHAR(255) NOT NULL,
    cognome_contraente VARCHAR(255) NOT NULL,
    via_contraente VARCHAR(255) NOT NULL,
    citta_contraente VARCHAR(255) NOT NULL,
    cap_contraente VARCHAR(6) NOT NULL,
    codice_fiscale_contraente VARCHAR(16) NOT NULL,
    p_iva_contraente VARCHAR(255) NOT NULL,
    telefono_contraente VARCHAR(15) NOT NULL,
    cellulare_contraente VARCHAR(15) NOT NULL,
    email_contraente VARCHAR(255) NOT NULL,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}beneficiario (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ragione_sociale_beneficiario VARCHAR(255) NOT NULL,
    via_beneficiario VARCHAR(255) NOT NULL,
    citta_beneficiario VARCHAR(255) NOT NULL,
    cap_beneficiario VARCHAR(6) NOT NULL,
    codice_fiscale_beneficiario VARCHAR(16) NOT NULL,
    p_iva_beneficiario VARCHAR(255) NOT NULL,
    details TEXT DEFAULT NULL,
    details_opt TEXT DEFAULT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}polizze (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_collaboratore INT(10) NOT NULL,
    id_compagnia INT(10) NOT NULL,
    netto INT(10) DEFAULT 0,
    diritti INT(10) DEFAULT 0,
    imponibile INT(10) DEFAULT 0,
    lordo INT(10) DEFAULT 0,
    spese INT(10) DEFAULT 0,
    imposte INT(10) DEFAULT 0,
    numero INT(30) NOT NULL,
    tipologia VARCHAR(255) NOT NULL,
    id_contraente INT(10) DEFAULT NULL,
    id_beneficiario INT(10) DEFAULT NULL,
    descrizione TEXT DEFAULT NULL,
    importo_gara INT(10) NOT NULL,
    massimale INT(20) NOT NULL,
    st DATE NOT NULL,
    et DATE NOT NULL,
    id_calendar_cat INT(5) DEFAULT NULL,
    consulenza INT(20) NOT NULL,
    incasso_data DATE NOT NULL,
    incasso_mod VARCHAR(255) NOT NULL,
    pagato_da_collaboratore INT(20) DEFAULT 0,
    collaboratore_pagato INT(1) DEFAULT 0,
    pagato_da_compagnia INT(20) DEFAULT 0,
    compagnia_pagato INT(1) DEFAULT 0,
    copia_direzione INT(1) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}pag_collaboratore (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_collaboratore INT(10) NOT NULL,
    da_pagare INT(10) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS {$prefix}pag_compagnia (
    id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_compagnia INT(10) NOT NULL,
    da_pagare INT(10) DEFAULT 0
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$menu_link = [[
    'link' => 'cfa',
    'label' => 'CFA',
    'icon' => 'shield-fill-check',
    'child' => [
        [
            'link' => 'allCollaboratori',
            'label' => 'Collaboratori',
            'icon' => 'person-vcard',
            'show_menu' => 1,
        ],
        [
            'link' => 'allCompagnie',
            'label' => 'Compagnie',
            'icon' => 'building',
            'show_menu' => 1,
        ],
        [
            'link' => 'allPolizze',
            'label' => 'Polizze',
            'icon' => 'file-post',
            'show_menu' => 1,
        ],
        [
            'link' => 'allContraenti',
            'label' => 'Contraenti',
            'icon' => 'person-fill-down',
            'show_menu' => 1,
        ],
        [
            'link' => 'allBeneficiari',
            'label' => 'Beneficiari',
            'icon' => 'person-fill-up',
            'show_menu' => 1,
        ],
        [
            'link' => 'allUtili',
            'label' => 'Utili CFA',
            'icon' => 'cash-coin',
            'show_menu' => 1,
        ],
        [
            'link' => 'allUtiliCollaboratori',
            'label' => 'Collaboratori',
            'icon' => 'person-vcard',
            'show_menu' => 1,
        ],
        [
            'link' => 'allUtiliCompagnie',
            'label' => 'Compagnie',
            'icon' => 'building',
            'show_menu' => 1,
        ],
        [
            'link' => 'allPagareCompagnie',
            'label' => 'Da pagare compagnie',
            'icon' => 'building',
            'show_menu' => 1,
        ],
        [
            'link' => 'allPagareCollaboratori',
            'label' => 'Da pagare collaboratori',
            'icon' => 'person-vcard',
            'show_menu' => 1,
        ],
    ],
]];

$query_drop_table = "DROP TABLE IF EXISTS {$prefix}collaboratori, {$prefix}compagnie, {$prefix}contraente, {$prefix}beneficiario, {$prefix}polizze, {$prefix}pag_collaboratore, {$prefix}pag_compagnia;";