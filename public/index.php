<?php

declare(strict_types = 1);

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

require_once APP_PATH . DIRECTORY_SEPARATOR . 'App.php';
require_once VIEWS_PATH . DIRECTORY_SEPARATOR . 'transactions.php';
