<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use TYield;

class Commands
{
    public function __construct(
        private DatabaseSpread $databaseSpread,
        private Formatter $formatter
    ) {}

    public function printTables(): void
    {
        foreach ($this->databaseSpread->getTables() as $table) {
            printLine((string) $table);
        }
    }

    public function getTablesWithSizes(): void
    {
        foreach ($this->databaseSpread->getTablesWithSizes() as $table) {
            printLine($table->getName() . ", size: " . $table->getSize() . " bytes");
        }
    }

    public function getFields(?string $table): void
    {
        if ($table) {
            $this->formatter->getFieldsFromTable($table);
        } else {
            $this->formatter->getFieldsFromAllTables();
        }
    }

    public function getFieldsWithDetails(?string $table): void
    {
        if ($table) {
            $this->formatter->getFieldsFromTable($table);
        } else {
            $this->formatter->getFieldsFromAllTables();
        }
    }
}