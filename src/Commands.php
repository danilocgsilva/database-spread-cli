<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use TYield;

class Commands
{
    private Formatter $formatter;
    
    public function __construct(
        private DatabaseSpread $databaseSpread
    ) {
        $this->formatter = new Formatter($databaseSpread);
    }

    /**
     * Prints table from the selected database
     *
     * @return void
     */
    public function get_tables(): void
    {
        foreach ($this->databaseSpread->getTables() as $table) {
            printLine((string) $table);
        }
    }

    public function get_tables_with_sizes(): void
    {
        foreach ($this->databaseSpread->getTablesWithSizes() as $table) {
            printLine($table->getName() . ", size: " . $table->getSize() . " bytes");
        }
    }

    public function get_tables_with_heights(): void
    {
        foreach ($this->databaseSpread->getTablesWithHeights() as $tableHighed) {

            printLine(
                sprintf(
                    "%s, height: %s rows", 
                    $tableHighed->getName(), 
                    $tableHighed->getHeight()
                )
            );
        }
    }

    public function get_fields(?string $table): void
    {
        if ($table) {
            $this->formatter->getFieldsFromTable($table);
        } else {
            $this->formatter->getFieldsFromAllTables();
        }
    }

    public function get_fields_details(?string $table): void
    {
        if ($table) {
            $this->formatter->getFieldsDetailsFromTable($table);
        } else {
            $this->formatter->getFieldsDetailsFromAllTables();
        }
    }
}