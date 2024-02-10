<?php

declare(strict_types=1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

// c.f.
// https://www.php.net/manual/ja/directory.read.php
// https://www.php.net/manual/ja/function.file-get-contents.php
// https://www.php.net/manual/ja/function.fgetcsv.php
// https://www.php.net/manual/ja/function.str-replace.php
// https://www.php.net/manual/ja/language.basic-syntax.phpmode.php
// https://www.php.net/manual/ja/language.variables.scope.php
// https://www.php.net/manual/ja/function.list.php
// https://www.php.net/manual/ja/function.abs.php
// https://www.php.net/manual/ja/datetime.formats.php
// https://www.php.net/manual/ja/function.trigger-error.php
// https://www.php.net/manual/ja/function.is-dir.php
// https://www.php.net/manual/ja/function.array-merge.php
// https://www.php.net/manual/ja/function.array-map.php
// https://www.php.net/manual/ja/function.number-format.php

require_once APP_PATH . 'App.php';
require_once VIEWS_PATH . 'transactions.php';
