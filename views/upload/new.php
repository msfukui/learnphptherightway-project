<!DOCTYPE html>
<html>
<body>

<h2>ファイルアップロード</h2>

<? if (isset($error)) { ?>
  <p><?= $error ?></p>
<? } ?>

<form action="/upload/create" method="post" enctype="multipart/form-data">
  ファイルを選択:
  <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="アップロード" name="submit">
</form>

</body>
</html>
