<?php

namespace Tests\Unit\Issue;

use Domain\Issue\IssueStatus;
use PHPUnit\Framework\TestCase;

class IssueStatusTest extends TestCase
{
    public function test_IssueStatusの初期値は、openedであること(): void
    {
        $sut = IssueStatus::create();
        $this->assertSame('opened', $sut->value());
        $this->assertSame('新規', $sut->name());
        $this->assertSame(false, $sut->closed());
    }

    public function test_IssueStatusを値から作る_working(): void
    {
        $sut = IssueStatus::createFromValue('working');
        $this->assertSame('working', $sut->value());
        $this->assertSame('作業中', $sut->name());
        $this->assertSame(false, $sut->closed());
    }

    public function test_IssueStatusを値から作る_done(): void
    {
        $sut = IssueStatus::createFromValue('done');
        $this->assertSame('done', $sut->value());
        $this->assertSame('完了', $sut->name());
        $this->assertSame(true, $sut->closed());
    }

    public function test_想定していない値が指定されたら例外が発生すること_other(): void
    {
        $this->expectException(\Exception::class);

        $sut = IssueStatus::createFromValue('other');
    }

    public function test_openedなら、workingに変更可能である(): void
    {
        $sut = IssueStatus::createFromValue('opened');
        $nextStatuses = $sut->getNextStatuses();
        $this->assertSame(2, count($nextStatuses));
        $this->assertSame('opened', $nextStatuses[0]->value());
        $this->assertSame('working', $nextStatuses[1]->value());
    }
    public function test_workingなら、doneに変更可能である(): void
    {
        $sut = IssueStatus::createFromValue('working');
        $nextStatuses = $sut->getNextStatuses();
        $this->assertSame(2, count($nextStatuses));
        $this->assertSame('working', $nextStatuses[0]->value());
        $this->assertSame('done', $nextStatuses[1]->value());
    }
}
