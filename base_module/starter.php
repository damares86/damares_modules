<?php

declare(strict_types=1);

$op = $op ?? '';

if ($op === 'add') {
    // Custom actions during installation
} elseif ($op === 'rm') {
    // Custom actions during removal
}

require __DIR__ . '/config.php';
