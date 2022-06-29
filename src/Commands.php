<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;

class Commands
{
    private Formatter $formatter;

    private array $meta = [
        "help" => "Prints possible options allowable.",
        "get_tables" => "Prints all tables.",
        "get_tables_with_sizes" => "Prints tables with sizes.",
        "get_tables_with_heights" => "Print tables with its row count.",
        "get_fields" => "Show fields from a table or all tables. If need just to print fields from just one table, type a second argument beign the table name.",
        "get_fields_details" => "Show fields with its details. If needs just to print details from just one table, type a second argumento beign the table name."
    ];
    
    public function __construct(
        private DatabaseSpread $databaseSpread
    ) {
        $this->formatter = new Formatter($databaseSpread);
    }

    public function help(): void
    {
        foreach (get_class_methods(self::class) as $method) {
            if (!in_array($method, array_keys($this->meta))) {
                continue;
            }

            printLine(
                sprintf("* %s: %s", $method, $this->meta[$method])
            );
        }
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
    public function get_tables_with_sizes(): void
    {
        foreach ($this->databaseSpread->getTablesWithSizes() as $table) {
            printLine($table->getName() . ", size: " . $table->getSize() . " bytes");
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