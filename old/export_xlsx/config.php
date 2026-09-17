<?php

declare(strict_types=1);

// Plugin information
$pluginname = 'export_xlsx';
$description = 'Export data from a table in XLSX format';
$link_parent = 'export_xlsx';

$prefix = $prefix ?? '';
$query_create_table = '';
$query_drop_table = '';
$menu_link = [];