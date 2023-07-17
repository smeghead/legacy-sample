<?php

namespace Tests\Unit\FormRequest;

use App\Http\Requests\SearchIssue;
use PHPUnit\Framework\TestCase;

class SearchIssueTest extends TestCase
{
    public function testGetKeywordsパラメータなし(): void
    {
        $sut = new SearchIssue();
        $this->assertSame([], $sut->getKeywords());
    }
    public function testGetKeywordsパラメータ空(): void
    {
        $sut = new SearchIssue([
            'q' => '',
        ]);
        $this->assertSame([], $sut->getKeywords());
    }
    public function testGetKeywordsパラメータあり(): void
    {
        $sut = new SearchIssue([
            'q' => 'keyword',
        ]);
        $this->assertSame(['keyword'], $sut->getKeywords());
    }
    public function testGetKeywordsパラメータ複数のキーワード(): void
    {
        $sut = new SearchIssue([
            'q' => 'keyword1 keyword2',
        ]);
        $this->assertSame(['keyword1', 'keyword2'], $sut->getKeywords());
    }
    public function testGetKeywords全角空白で区切られたパラメータ複数のキーワード(): void
    {
        $sut = new SearchIssue([
            'q' => 'keyword1　keyword2',
        ]);
        $this->assertSame(['keyword1', 'keyword2'], $sut->getKeywords());
    }
}
