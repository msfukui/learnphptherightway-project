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
                <?php [$v, $total_income, $total_expense] = getCsvData(); ?>
                <?php foreach ($v as $row) : ?>
                <tr>
                    <td><?php echo $row[0] ?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><?php echo $row[3] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo $total_income ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo $total_expense ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo $total_income + $total_expense ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
