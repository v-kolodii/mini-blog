<?php

require __DIR__ . '/../config/bootstrap.php';

/** @var PDO $pdo */
/** @var Smarty\Smarty $smarty */

$tables = $pdo->query('SHOW TABLES')->fetchAll();

$smarty->assign('greeting', 'Hello World!');
$smarty->assign('pdo_status', 'Connected');
$smarty->assign('tables_count', count($tables));
$smarty->display('test.tpl');
