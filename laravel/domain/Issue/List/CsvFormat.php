<?php

declare(strict_types=1);

namespace Domain\Issue\List;

use Domain\Issue\IssueStatus;

/**
 * 課題のダウンロード機能のCSV形式
 */
class CsvFormat {
    private \DateTimeImmutable $now;

    public function __construct(\DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    /**
     * @return string[] CSVのヘッダー(項目一覧)
     */
    public function getHeaders(): array
    {
        return ['ID', '件名', '説明', '期限', '状態', '作成日時', '更新日時'];
    }

    /**
     * 課題の1レコードの連想配列をCSVの1行のデータに変換します。
     * @param array $issue 課題の1レコードの連想配列
     * @return string[] CSVの1行のデータ
     */
    public function convertRow(array $issue): array
    {
        $validFields = [
            'id',
            'summary',
            'description',
            'deadline',
            'status',
            'created_at',
            'updated_at',
        ];
        foreach ($validFields as $f) {
            if ( ! array_key_exists($f, $issue)) {
                throw new \Exception(sprintf('invalid issue row. %s', $f));
            }
        }
        return [
            $issue['id'],
            $issue['summary'],
            $issue['description'],
            $issue['deadline'],
            IssueStatus::createFromValue($issue['status'])->name(),
            $issue['created_at'],
            $issue['updated_at'],
        ];
    }

    /**
     * ダウンロードされるCSVファイルのファイル名
     * @return string CSVファイルのファイル名
     */
    public function getDownloadFilename(): string
    {
        return sprintf('issues-%s.csv', $this->now->format('YmdHis'));
    }
}