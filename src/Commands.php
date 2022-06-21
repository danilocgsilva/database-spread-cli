<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use TYield;

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

    public function getTablesWithSizes(): void
    {
        foreach ($this->databaseSpread->getTablesWithSizes() as $table) {
            printLine($table->getName() . ", size: " . $table->getSize() . " bytes");
        }
    }

    public function getFields(?string $table): void
    {
        if ($table) {
            $this->getFieldsFromTable($table);
        } else {
            $this->getFieldsFromAllTables();
        }
    }

    private function getFieldsFromTable(string $table): void
    {
       foreach ($this->databaseSpread->getFields($table) as $field) {
            printLine($field->getName());
        }
    }

    private function getFieldsFromAllTables(): void
    {
        foreach ($this->databaseSpread->getTables() as $table) {
            $this->printTableDataForSingleTable($table);
        }
    }

    private function printTableDataForSingleTable($table): void
    {
        printLine("Table: " . ($tableName = $table->getName()));
        foreach ($this->databaseSpread->getFields($tableName) as $field) {
            printLine(" * " . $field->getName());
        }
    }
}