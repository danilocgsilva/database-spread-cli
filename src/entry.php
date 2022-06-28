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

if (isset($argv[1])) {
    switch ($argv[1]) {
        case "get_tables":
            $command->{"get_tables"}();
            break;
        case "get_tables_with_sizes":
            $command->{"get_tables_with_sizes"}();
            break;
        case "get_tables_with_heights":
            $command->{"get_tables_with_heights"}();
            break;
        case "get_fields":
            $command->{"get_fields"}($argv[2] ?? null);
            break;
        case "get_fields_details":
            $command->{"get_fields_details"}($argv[2] ?? null);
            break;
        default:
            printLine("You have provided an unknown argument.");
    }
} else {
    printLine("You need to provide an argument tellign what you want to do.");
}
