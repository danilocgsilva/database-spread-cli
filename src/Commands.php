<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;

class Commands
{
    public function __construct(
        private DatabaseSpread $databaseSpread
    ) {}

    public function printTables(): void
    {
        foreach ($this->databaseSpread->getTables() as $table) {
            printLine((string) $table);
        }
    }

    function getTablesWithSizes() {
        foreach ($this->databaseSpread->getTablesWithSizes() as $table) {
            printLine($table->getName() . ": " . $table->getSize());
        }
    }
}