<?php

namespace Tests\Unit\Issue;

use Domain\Issue\IssuePriority;
use Domain\Issue\IssueStatus;
use PHPUnit\Framework\TestCase;

class IssuePriorityTest extends TestCase
{
    public function test_IssuePriority完了した課題の優先度は空文字になる(): void
    {
        $baseDate = new \DateTimeImmutable('2023-01-01');
        $status = IssueStatus::createFromValue('done');
        $sut = new IssuePriority($baseDate, $status, '2023-01-01');
        $this->assertSame('', $sut->value());
    }

    public function test_IssuePriority期限が100年後の課題の優先度は空文字になる(): void
    {
        $baseDate = new \DateTimeImmutable('2023-01-01');
        $status = IssueStatus::createFromValue('opened');
        $sut = new IssuePriority($baseDate, $status, '2123-01-01');
        $this->assertSame('', $sut->value());
    }

    public function test_IssuePriority期限が1ヶ月後の課題の優先度は空文字になる(): void
    {
        $baseDate = new \DateTimeImmutable('2023-01-01');
        $status = IssueStatus::createFromValue('opened');
        $sut = new IssuePriority($baseDate, $status, '2023-02-01');
        $this->assertSame('', $sut->value());
    }

    public function test_IssuePriority期限が3日後の課題の優先度はsoonになる(): void
    {
        $baseDate = new \DateTimeImmutable('2023-01-01');
        $status = IssueStatus::createFromValue('opened');
        $sut = new IssuePriority($baseDate, $status, '2023-01-04');
        $this->assertSame('soon', $sut->value());
    }

    public function test_IssuePriority期限が当日の課題の優先度はtodayになる(): void
    {
        $baseDate = new \DateTimeImmutable('2023-01-01');
        $status = IssueStatus::createFromValue('opened');
        $sut = new IssuePriority($baseDate, $status, '2023-01-01');
        $this->assertSame('today', $sut->value());
    }

    public function test_IssuePriority期限が過去の課題の優先度はdeadになる(): void
    {
        $baseDate = new \DateTimeImmutable('2023-01-01');
        $status = IssueStatus::createFromValue('opened');
        $sut = new IssuePriority($baseDate, $status, '2022-12-31');
        $this->assertSame('dead', $sut->value());
    }

    public function test_IssuePriority期限が不正な文字列の課題の優先度は空文字になる(): void
    {
        $baseDate = new \DateTimeImmutable('2023-01-01');
        $status = IssueStatus::createFromValue('opened');
        $sut = new IssuePriority($baseDate, $status, 'invalid date');
        $this->assertSame('', $sut->value());
    }
}
