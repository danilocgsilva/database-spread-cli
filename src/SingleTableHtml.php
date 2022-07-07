<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

use Danilocgsilva\DatabaseSpread\Main as DatabaseSpread;

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

    public function printTableDataDetailsForSingleTableHtml(string $tableName): void
    {
        printLine(sprintf("<h2>%s</h2>", $tableName), 2);

        printLine("<ul>", 2);

        $fieldTemplate = "<li>%s, type: %s</li>";

        foreach ($this->databaseSpread->getFields($tableName) as $field) {
            printLine(
                sprintf(
                    $fieldTemplate,
                    $field->getName(),
                    $field->getType()
                )
            , 3);
        }

        printLine("</ul>\n", 2);
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