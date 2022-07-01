<?php

declare(strict_types=1);

function printLine(string $content, int $tabs = 0)
{
    $startingSpace = "";
    for ($i = 0; $i < $tabs; $i++) {
        $startingSpace .= "    ";
    }
    print($startingSpace . $content . "\n");
}

function htmlByte(int $size): string
{
    return (string) $size . " B";
}

function htmlMegabyte(int $size): string
{
    return number_format(
        $size / 1024 / 1024, 
        2,
        ".",
        ","
    ) . " MB";
}

function getHtmlConverter(string $userQuery = null)
{
    if (in_array($userQuery, ["m", "mb"])) {
        return fn(int $size) => htmlMegabyte($size);
    } else {
        return fn(int $size) => htmlByte($size);
    }
}

