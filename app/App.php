<?php

declare(strict_types = 1);

function getCsvData() : array
{
    $dir = dir(FILES_PATH);

    $v = [];
    $total_income = 0;
    $total_expense = 0;

    while ($file = $dir->read()) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        $fs = fopen(FILES_PATH . $file, 'r');
        if (!$fs) {
            throw new Exception('File ' . $row . ' not opened.');
        }
        $count = 0;
        $amount = 0;
        while ($row = fgetcsv($fs)) {
            if ($count == 0) {
                $count++;
                continue;
            }
            $v[] = $row;
            $amount = (float)str_replace(',', '', str_replace('$', '', $row[3]));
            if ($amount > 0) {
                $total_income += $amount;
            } else {
                $total_expense += $amount;
            }
            $count++;
        }
    }

    return [$v, $total_income, $total_expense];
}
