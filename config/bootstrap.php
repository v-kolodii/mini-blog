<?php

declare(strict_types=1);

use App\SmartyPlugin\UrlBuilder;
use Smarty\Smarty;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/config.php';

// PDO
$dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
    $config['db']['host'],
    $config['db']['port'],
    $config['db']['name'],
);

$pdo = new PDO($dsn, $config['db']['user'], $config['db']['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

// Smarty
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../templates');
$smarty->setCompileDir(__DIR__ . '/../templates_c');
$smarty->setEscapeHtml(true);

$smarty->registerPlugin(
    Smarty::PLUGIN_FUNCTION,
    'url',
    [UrlBuilder::class, 'build']
);
