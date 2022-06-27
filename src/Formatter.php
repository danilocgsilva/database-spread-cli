<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\DatabaseStructure\Field;

class Formatter
{
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
    
    private function fieldName(Field $field): void
    {
        printLine($field->getName());
    }


    private function printTableDataForSingleTable($table): void
    {
        printLine("Table: " . ($tableName = $table->getName()));
        foreach ($this->databaseSpread->getFields($tableName) as $field) {
            printLine(" * " . $field->getName());
        }
    }
}