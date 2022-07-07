<?php

declare(strict_types=1);

namespace Danilocgsilva\DatabaseSpreadCli;

class HelpHelper
{
    private const META = [
        "help" => "Prints possible options allowable.",
        "get_tables" => "Prints all tables.",
        "get_tables_with_sizes" => "Prints tables with sizes.",
        "get_tables_with_heights" => "Print tables with its row count.",
        "get_fields" => "Show fields from a table or all tables. If need just to print fields from just one table, type a second argument beign the table name.",
        "get_fields_details" => "Show fields with its details. If needs just to print details from just one table, type a second argumento beign the table name.",
        "get_tables_html" => "Prints html code for tables listing", 
        "get_tables_with_sizes_html" => "Prints the tables with its sizes in html format, thus can be displayied in a browser.", 
        "get_fields_html" => "Prints the fields from all tables. If a second argument is provided, prints fields just from the table from the second argument."
    ];
    
    public static function help(): void
    {
        printLine("The parameters that you can use:\n");
        
        foreach (self::META as $key => $value) {
            printLine(sprintf("* %s: %s", $key, $value));
        }
    }
}