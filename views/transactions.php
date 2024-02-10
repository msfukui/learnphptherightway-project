<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th, table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th, tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Check #</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php [$record, $total_income, $total_expense] = getCsvData(FILES_PATH); ?>
    <?php foreach ($record as $row) : ?>
        <tr>
            <td><?= toDateformat($row['date']) ?></td>
            <td><?= $row['check'] ?></td>
            <td><?= $row['description'] ?></td>
            <?php if (isIncome(toAmount($row['amount']))) : ?>
                <td style="color: green"><?= toAmountFormat($row['amount']) ?></td>
            <?php else : ?>
                <td style="color: red"><?= toAmountFormat($row['amount']) ?></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?= toAmountFormat($total_income) ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?= toAmountFormat($total_expense) ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?= toAmountFormat($total_income + $total_expense) ?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
