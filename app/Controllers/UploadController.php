<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

class UploadController
{
    public function index(): View
    {
        return View::make('upload/transactions');
    }

    public function new(): View
    {
        return View::make('upload/new');
    }

    public function create(): View
    {
        if (! isset($_FILES['fileToUpload'])) {
            $error = 'ファイルを選択してからアップロードボタンを押してください';
            return View::make('upload/new', ['error' => $error]);
        }

        [$isValid, $error] = $this->validateForUpload($_FILES['fileToUpload']);
        if (! $isValid) {
            return View::make('upload/new', ['error' => $error]);
        }

        $filename = $_FILES['fileToUpload']['tmp_name'];
        $rows = $this->readUploadFile($filename);

        // 登録完了ページを表示する
        return View::make('upload/created', ['filename' => $filename, 'rows' => $rows]);
    }

    public function done(): View
    {
        return View::make('upload/done');
    }

    /**
     * アップロードファイルの妥当性をまとめて検証する
     *
     * @param array $fileToUpload $_FILES['fileToUpload'] の値
     * @return array<bool, string> bool: 検証結果, string: エラーメッセージ
     */
    private function validateForUpload(array $fileToUpload): array
    {
        if ($fileToUpload['error'] !== UPLOAD_ERR_OK) {
            return [false, 'アップロードに失敗しました(' . $fileToUpload['error'] . ')'];
        }

        $allowed_types = ['text/csv'];
        if (!in_array($fileToUpload['type'], $allowed_types)) {
            return [false, 'エラー: CSVファイル以外はアップロードできません。'];
        }

        $max_size = 10 * 1024 * 1024;
        if ($fileToUpload['size'] > $max_size) {
            return [false, 'エラー: ファイルサイズが大きすぎます。(max_size: 1MB)'];
        }

        return [true, ''];
    }

    private function readUploadFile(string $file): array
    {
        $header = [];
        $rows = [];

        $handle = fopen($file, 'r');
        if (! $handle) {
            return [];
        }

        $header = fgetcsv($handle);
        while($row = fgetcsv($handle)) {
            $rows[] = array_combine($header, $row);
        }
        fclose($handle);

        return $rows;
    }
}
