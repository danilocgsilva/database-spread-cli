<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;
use Danilocgsilva\DatabaseSpread\DatabaseStructure\Table;

class SingleTableHtml
{
    public function __construct(
        private DatabaseSpread $databaseSpread,
        private Html $html
    ) {}
    
    /**
     * Prints the html data to show data from a single table, providing
     *   a list of table fields as well.
     *
     * @param string $tableName
     * @return void
     */
    public function printTableDataForSingleTableHtml(string $tableName)
    {
        printLine(sprintf("<h2>%s</h2>", $tableName), 2);

        printLine("<ul>", 2);

        $fieldTemplate = "<li>%s</li>";

        foreach ($this->databaseSpread->getFields($tableName) as $field) {
            printLine(
                sprintf(
                    $fieldTemplate,
                    $field->getName()
                )
            , 3);
        }

        printLine("</ul>\n", 2);
    }

    /**
     * Loop through all table to get data from each.
     * Uses self::printTableDataForSingleTableHtml
     *
     * @return void
     */
    public function printFieldsFromAllTables(): void
    {
        $this->printHead();
        
        foreach ($this->databaseSpread->getTables() as $table) {
            $this->printTableDataForSingleTableHtml($table->getName());
        }

        printLine("   <ul>\n\n</body>\n</html>\n");
    }

    /**
     * Prints a single table detail in html format
     *
     * @param string $tableName
     * @return void
     */
    public function printTableDataDetailsForSingleTableHtml(Table $table): void
    {
        printLine(sprintf("<h2>%s</h2>", ($tableName = $table->getName())), 2);
        
        $this->printSummary($table);

        printLine("<ul>", 2);

        $fieldTemplate = "<li>%s\n"
            . "                <ul>\n"
            . "                    <li>type: %s</li>\n"
            . "                    <li>nullable: %s</li>\n"
            . "                    <li>key: %s</li>\n"
            . "                    <li>extra: {%s}</li>\n"
            . "                </ul>\n"
            . "            </li>\n";

        foreach ($this->databaseSpread->getFields($tableName) as $field) {
            printLine(
                sprintf(
                    $fieldTemplate,
                    $field->getName(),
                    $field->getType(),
                    $field->getNull(),
                    $field->getKey() === "" ? "any" : $field->getKey(),
                    $field->getExtra()
                )
            , 3);
        }

        printLine("</ul>\n", 2);
    }

    /**
     * Prints the rows count and size in html format.
     *
     * @return void
     */
    private function printSummary(Table $table)
    {
        $this->databaseSpread->hydrateSize($table);
        $this->databaseSpread->hydrateHeight($table);
        
        printLine("<ul>");
        printLine(sprintf("<li>Rows count: %s</li>", $table->getHeight()));
        printLine(sprintf("<li>Size: %s</li>", $table->getSize()));
        printLine("</ul>");
    }

    private function printHead(): void
    {
        printLine(
            sprintf(
                $this->html->getHeadHtmlTemplate(),
                $this->databaseSpread->getDatabaseName()
            )
        );
    }
}