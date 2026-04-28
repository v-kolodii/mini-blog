<?php

declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

/** @var PDO $pdo */

$sql = file_get_contents(__DIR__ . '/../database/schema.sql');

if ($sql === false) {
    fwrite(STDERR, 'Cannot read schema.sql');
    exit(1);
}

try {
    $pdo->exec($sql);
    echo 'Schema applied' . PHP_EOL;
} catch (PDOException $e) {
    fwrite(STDERR, 'Migration failed: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}