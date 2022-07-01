<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;

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

    /**
     * Prints tables with its size in storage
     *
     * @return void
     */
    public function get_tables_with_sizes(string $unit = null): void
    {
        $converter = getHtmlConverter($unit);
        
        foreach ($this->databaseSpread->getTablesWithSizes() as $table) {
            printLine($table->getName() . ", size: " . $converter($table->getSize()));
        }
    }

    /**
     * Get tables and prints the row count
     *
     * @return void
     */
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

    /**
     * Prints fields from all tables or just one
     *
     * @param string|null $table
     * @return void
     */
    public function get_fields(?string $table): void
    {
        if ($table) {
            $this->formatter->getFieldsFromTable($table);
        } else {
            $this->formatter->getFieldsFromAllTables();
        }
    }

    /**
     * Prints the fields its detaisl
     *
     * @param string|null $table
     * @return void
     */
    public function get_fields_details(?string $table): void
    {
        if ($table) {
            $this->formatter->getFieldsDetailsFromTable($table);
        } else {
            $this->formatter->getFieldsDetailsFromAllTables();
        }
    }
}
