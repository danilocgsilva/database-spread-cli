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

try {
    $pdo = new PDO(sprintf('mysql:host=%s', $_ENV['HOST']), $_ENV['USER'], $_ENV['PASS']);
} catch (PDOException $e) {
    print("Error. Check database connection.\n");
    exit();
}
$databaseSpread = new DatabaseSpread($pdo);
$databaseSpread->setDatabaseName($_ENV['NAME']);
$command = new Commands($databaseSpread);

if ($argv[1] === "get_tables") {
    $command->printTables();
    exit();
}

if ($argv[1] === "get_tables_with_sizes") {
    $command->getTablesWithSizes();
    exit();
}

if ($argv[1] === "get_fields") {
    $command->getFields($argv[2] ?? null);
    exit();
}

if ($argv[1] === "get_fields_details") {
    $command->getFieldsWithDetails($argv[2] ?? null);
    exit();
}

printLine("You have provided an unknown argument.");
