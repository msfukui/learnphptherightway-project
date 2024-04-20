<!DOCTYPE html>
<html>
<head>
   <title>登録を完了しました</title>
   <meta http-equiv="refresh" content="2; url=/upload/done">
</head>
<body>
   <p>自動で切り替わらない場合は <a href="/upload/done">完了</a> ページに進んでください</p>
    <? if (isset($filename)) { ?>
    <p><?= $filename ?></p>
    <? } ?>
    <? if (isset($rows)) { ?>
        <p>登録件数: <?= count($rows) ?></p>
        <? foreach ($rows as $row) { ?>
            <p><?= implode(',', $row) ?></p>
        <? } ?>
    <? } ?>
</body>
</html>
