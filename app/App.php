<?php

declare(strict_types=1);

/**
 * @param string $filePath
 * @return array{ array{ date: string, check: string, description: string, amount: float }[], float, float }
 */
function getCsvData(string $filePath): array
{
    $files = getFilesList($filePath);

    $rows = [];
    foreach ($files as $file) {
        $rows = array_merge($rows, getRows($file, 'transactionsHandler'));
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
 * @param callable|null $handle
 * @return array{date: string, check: string, description: string, amount: float}[]
 */
function getRows(string $file, ?callable $handle = null): array
{
    $fs = fopen($file, 'r');

    if (!$fs) {
        trigger_error('File ' . $file . ' not opened.');
    }

    fgetcsv($fs); // 先頭の1行目はヘッダのため読み飛ばす

    $rows = [];

    while ($row = fgetcsv($fs)) {
        if ($handle == null) {
            // 詰める関数が提供されていない場合はそのまま詰める
            $rows[] = $row;
        } else {
            // 詰める関数が提供されている場合は引き渡して詰める
            $rows[] = $handle($row);
        }
    }

    return $rows;
}

/**
 * @param string[] $row
 * @return array{date: string, check: string, description: string, amount: float}
 */
function transactionsHandler(array $row): array
{
    [$date, $check, $description, $amount] = $row;

    return [
        'date' => $date,
        'check' => $check,
        'description' => $description,
        'amount' => toAmount($amount),
    ];
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
    return DateTimeImmutable::createFromFormat("m/d/Y", $date)
        ->format("M d, Y");
}

function toAmountFormat(float $amount): string
{
    return (isIncome($amount) ? '' : '-') . '$' . number_format(abs($amount), 2);
}
