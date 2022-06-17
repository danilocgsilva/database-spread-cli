<?php

declare(strict_types=1);

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use Danilocgsilva\DatabaseSpreadCli\Commands;
use Dotenv\Dotenv;

const BASE_PATH = "__DIR__" . DIRECTORY_SEPARATOR . "..";
require BASE_PATH . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

if (!isset($argv[1])) {
    printLine(("You may provide an argument to tell what you want to do."));
    exit();
}

$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s', $_ENV['HOST'], $_ENV['NAME']), $_ENV['USER'], $_ENV['PASS']);
$databaseSpread = new DatabaseSpread($pdo);
$command = new Commands($databaseSpread);

if ($argv[1] === "get_tables") {
    $command->printTables();
    exit();
}

if ($argv[1] === "get_tables_with_sizes") {
    $command->getTablesWithSizes();
    exit();
}

printLine("You have provided an unknown argument.");

