<?php

declare(strict_types=1);

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use Dotenv\Dotenv;

const BASE_PATH = "__DIR__" . DIRECTORY_SEPARATOR . "..";
require BASE_PATH . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s', $_ENV['HOST'], $_ENV['NAME']), $_ENV['USER'], $_ENV['PASS']);
$databaseSpread = new DatabaseSpread($pdo);

function printLine(string $content)
{
    print($content . "\n");
}

printLine("Here the job will be done!");

foreach ($databaseSpread->getTables() as $table) {
    printLine((string) $table);
}
