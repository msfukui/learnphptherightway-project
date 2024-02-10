<?php

declare(strict_types=1);

/**
 * @param string $filePath
 * @return array{ { date: string, check: string, description: string, amount: float }[], float, float }
 */
function getCsvData(string $filePath): array
{
    $files = getFilesList($filePath);

    $rows = [];
    foreach ($files as $file) {
        $rows = array_merge($rows, getRows($file));
    }

    [$total_income, $total_expense] = getTotal(
        array_map(function (array $r) {
            return $r['amount'];
        }, $rows)
    );

    return [$rows, $total_income, $total_expense];
}

/**
 * @param string $filesPath
 * @return string[]
 */
function getFilesList(string $filesPath): array
{
    $files = [];
    $dir = dir($filesPath);

    while ($file = $dir->read()) {
        $file = $filesPath . $file;

        if (is_dir($file)) {
            continue;
        }

        $files[] = $file;
    }

    return $files;
}

/**
 * @param string $file
 * @return array{date: string, check: string, description: string, amount: float}[]
 */
function getRows(string $file): array
{
    $fs = fopen($file, 'r');

    if (!$fs) {
        trigger_error('File ' . $file . ' not opened.');
    }

    fgetcsv($fs); // 先頭の1行目はヘッダのため読み飛ばす

    $rows = [];

    while ($row = fgetcsv($fs)) {
        $rows[] = [
            'date' => $row[0],
            'check' => $row[1],
            'description' => $row[2],
            'amount' => toAmount($row[3]),
        ];
    }

    return $rows;
}

/**
 * @param float[] $rows
 * @return float[]
 */
function getTotal(array $rows): array
{
    $total_income = 0;
    $total_expense = 0;

    foreach ($rows as $row) {
        $amount = $row;
        if (isIncome($amount)) {
            $total_income += $amount;
        } else {
            $total_expense += $amount;
        }
    }

    return [$total_income, $total_expense];
}

function toAmount(string $amount): float
{
    return (float)str_replace([',', '$'], '', $amount);
}

function isIncome(float $amount): bool
{
    return $amount >= 0;
}

function toDateformat(string $date): string
{
    $d = DateTimeImmutable::createFromFormat("m/d/Y", $date);
    return $d->format("M d, Y");
}

function toAmountFormat(float $amount): string
{
    return (isIncome($amount) ? '' : '-') . '$' . number_format(abs($amount), 2);
}
