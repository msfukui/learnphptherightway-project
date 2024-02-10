<?php

declare(strict_types = 1);

/**
 * @throws Exception
 */
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
            throw new Exception('File ' . $file . ' not opened.');
        }
        $count = 0;
        while ($row = fgetcsv($fs)) {
            if ($count == 0) {
                $count++;
                continue;
            }
            $v[] = $row;
            $amount = toAmount($row[3]);
            if (isIncome($amount)) {
                $total_income += $amount;
            } else {
                $total_expense += abs($amount);
            }
            $count++;
        }
    }

    return [$v, $total_income, $total_expense];
}

function toAmount(string $amount) : float
{
    return (float)str_replace(',', '', str_replace('$', '', $amount));
}

function isIncome(float $amount) : bool
{
    return $amount >= 0;
}

function toDateformat(string $date) : string
{
    $d = DateTimeImmutable::createFromFormat("m/d/Y", $date);
    return $d->format("M d, Y");
}
