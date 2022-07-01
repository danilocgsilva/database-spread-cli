<?php

declare(strict_types=1);

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use Danilocgsilva\DatabaseSpreadCli\Commands;
use Danilocgsilva\DatabaseSpreadCli\HelpHelper;
use Danilocgsilva\DatabaseSpreadCli\Html;
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


if (isset($argv[1])) {

    if ($argv[1] === "help") {
        HelpHelper::help();
        exit();
    }

    $htmlQuery = [
        "get_tables_html", 
        "get_tables_with_sizes_html", 
        "get_fields_html",
        "get_fields_details_html"
    ];

    if (in_array($argv[1], $htmlQuery)) {
        $command = new Html($databaseSpread);
        match ($argv[1]) {
            "get_tables_html" => $command->{"get_tables_html"}($argv[2] ?? null),
            "get_tables_with_sizes_html" => $command->{"get_tables_with_sizes_html"}($argv[2] ?? null),
            "get_fields_html" => $command->{"get_fields_html"}($argv[2] ?? null),
            "get_fields_details_html" => $command->{"get_fields_details_html"}($argv[2] ?? null),
            default => printLine("You have provided an unknown argument.")
        };
    } else {
        $command = new Commands($databaseSpread);
        match ($argv[1]) {
            "get_tables" => $command->{"get_tables"}(),
            "get_tables_with_sizes" => $command->{"get_tables_with_sizes"}($argv[2] ?? null),
            "get_tables_with_heights" => $command->{"get_tables_with_heights"}(),
            "get_fields" => $command->{"get_fields"}($argv[2] ?? null),
            "get_fields_details" => $command->{"get_fields_details"}($argv[2] ?? null),
            default => printLine("You have provided an unknown argument.")
        };
    }
} else {
    printLine("You need to provide an argument tellign what you want to do.");
}
