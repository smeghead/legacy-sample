<?php

namespace Tests\Unit\Issue\List;

use Domain\Issue\List\CsvFormat;
use PHPUnit\Framework\TestCase;

class CsvFormatTest extends TestCase
{
    public function testGetHeaders_ヘッダ取得(): void
    {
        $sut = new CsvFormat(new \DateTimeImmutable('2023-07-12 01:01:02'));
        $this->assertSame(['ID', '件名', '説明', '期限', '状態', '作成日時', '更新日時'], $sut->getHeaders());
    }
    public function testConvertRow_不正な空配列を入力(): void
    {
        $this->expectException(\Exception::class);

        $sut = new CsvFormat(new \DateTimeImmutable('2023-07-12 01:01:02'));
        $issue = [];
        $sut->convertRow($issue);
    }
    public function testConvertRow_不正な配列を入力(): void
    {
        $this->expectException(\Exception::class);

        $sut = new CsvFormat(new \DateTimeImmutable('2023-07-12 01:01:02'));
        $issue = [
            'id' => '123',
            'summary' => 'test',
            'description' => 'description.',
        ];
        $sut->convertRow($issue);
    }
    public function testConvertRow_正常な入力(): void
    {
        $sut = new CsvFormat(new \DateTimeImmutable('2023-07-12 01:01:02'));
        $issue = [
            'id' => '123',
            'summary' => 'test',
            'description' => 'description.',
            'deadline' => '',
            'status' => 'opened',
            'created_at' => '2023-07-01 01:10:10',
            'updated_at' => '2023-07-01 01:11:10',
        ];
        $this->assertSame([
            '123',
            'test',
            'description.',
            '',
            '新規',
            '2023-07-01 01:10:10',
            '2023-07-01 01:11:10',
        ], $sut->convertRow($issue));
    }
    public function testGetDownloadFilename_正常な入力(): void
    {
        $sut = new CsvFormat(new \DateTimeImmutable('2023-07-12 01:01:02'));
        $this->assertSame('issues-20230712010102.csv', $sut->getDownloadFilename());
    }

}
