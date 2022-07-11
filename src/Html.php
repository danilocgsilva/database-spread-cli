<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use Danilocgsilva\DatabaseSpread\DatabaseStructure\Table;

class Html
{
    public function __construct(
        private DatabaseSpread $databaseSpread
    ) {}

    /**
     * Prints tables list as static html code for browser display
     *
     * @return void
     */
    public function get_tables_html(): void
    {
        print(
            sprintf(
                $this->getHeadHtmlTemplate(),
                $this->databaseSpread->getDatabaseName(),
                $this->databaseSpread->getDatabaseName()
            )
        );

        print("\n    <ul>\n");

        foreach ($this->databaseSpread->getTables() as $table) {
            printLine("        <li>" . (string) $table . "</li>");
        }
        
        printLine("   <ul>\n\n</body>\n</html>\n");
    }

    /**
     * Prints all tables for browsing in html, with the size datra
     *
     * @param string|null $unit
     * @return void
     */
    public function get_tables_with_sizes_html(string $unit = null): void
    {
        $converter = getHtmlConverter($unit);

        print(
            sprintf(
                $this->getHeadHtmlTemplate(),
                $this->databaseSpread->getDatabaseName()
            )
        );

        print("<ul>\n");

        foreach ($this->databaseSpread->getTablesWithSizes() as $table) {
            $tableStringTemplate = sprintf(
                "        <li>%s -> %s</li>",
                (string) $table,
                $converter($table->getSize())
            );
            printLine($tableStringTemplate);
        }
        
        printLine("   <ul>\n\n</body>\n</html>\n");
    }

    public function get_fields_html(?string $table): void
    {
        $singleTableHtml = new SingleTableHtml($this->databaseSpread, $this);
        if (!$table) {
            $singleTableHtml->printFieldsFromAllTables();
        } else {
            printLine(
                sprintf(
                    $this->getHeadHtmlTemplate(),
                    $table
                )
            );
            $singleTableHtml->printTableDataForSingleTableHtml($table);
            printLine("</body>", 1);
            printLine("</html>\n");
        }
    }

    public function get_fields_details_html(?string $table): void
    {
        if ($table) {
            $this->printFieldsDetailsFromTable($table);
        } else {
            $this->printFieldsDetailsFromAllTables();
        }
    }

    /**
     * Returns basic head html code template
     *
     * @return string
     */
    public function getHeadHtmlTemplate(): string
    {
        return <<<EOD
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>%s</title>
    </head>
    <body>
EOD;
    }

    private function printFieldsDetailsFromTable(string $tableName)
    {
        printLine(
            sprintf(
                $this->getHeadHtmlTemplate(),
                $this->databaseSpread->getDatabaseName()
            )
        );
        
        $singleTableHtml = new SingleTableHtml($this->databaseSpread, $this);
        $table = (new Table())->setName($tableName);
        $singleTableHtml->printTableDataDetailsForSingleTableHtml($table);

        printLine("   <ul>\n\n</body>\n</html>\n");
    }

    private function printFieldsDetailsFromAllTables()
    {
        printLine(
            sprintf(
                $this->getHeadHtmlTemplate(),
                $this->databaseSpread->getDatabaseName()
            )
        );
        
        $singleTableHtml = new SingleTableHtml($this->databaseSpread, $this);
        foreach ($this->databaseSpread->getTables() as $table) {
            $singleTableHtml->printTableDataDetailsForSingleTableHtml($table);
        }

        printLine("   <ul>\n\n</body>\n</html>\n");
    }
}
