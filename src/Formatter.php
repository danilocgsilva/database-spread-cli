<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\DatabaseStructure\Field;
use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use Danilocgsilva\DatabaseSpread\DatabaseStructure\Table;

class Formatter
{
    public function __construct(
        private DatabaseSpread $databaseSpread
    ) {}
    
    public function getFieldsFromTable(string $table): void
    {
        foreach ($this->databaseSpread->getFields($table) as $field) {
            $this->fieldName($field);
        }
    }

    public function getFieldsFromAllTables(): void
    {
        foreach ($this->databaseSpread->getTables() as $table) {
            $this->printTableDataForSingleTable($table);
        }
    }

    public function getFieldsDetailsFromTable(Table $table)
    {
        print(printLine($tableName = $table->getName()));
        foreach ($this->databaseSpread->getFields($tableName) as $field) {
            $this->fieldDetails($field);
        }
    }

    public function getFieldsDetailsFromAllTables(): void
    {
        foreach ($this->databaseSpread->getTables() as $table) {
            $this->getFieldsDetailsFromTable($table);
        }
    }

    private function fieldName(Field $field): void
    {
        printLine($field->getName());
    }

    private function fieldDetails(Field $field): void
    {
        $stringToPrint = sprintf(
            " * field name: %s, value type: %s, nullable?: %s, key: %s", 
            $field->getName(), 
            $field->getType(),
            $field->getNull(),
            $field->getKey() === "" ? "any" : $field->getKey(),
        );
        printLine($stringToPrint);
    }

    private function printTableDataForSingleTable($table): void
    {
        printLine("Table: " . ($tableName = $table->getName()));
        foreach ($this->databaseSpread->getFields($tableName) as $field) {
            printLine(" * " . $field->getName());
        }
    }
}
