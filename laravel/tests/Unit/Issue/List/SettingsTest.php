<?php

namespace Tests\Unit\Issue\List;

use Domain\Issue\List\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function test_一覧に表示する項目(): void
    {
        $sut = new Settings();
        $this->assertSame(['id', 'summary', 'deadline', 'description', 'status'], $sut->getListFields());
    }

    public function test_一覧に表示する件数(): void
    {
        $sut = new Settings();
        $this->assertSame(3, $sut->getCountParPage());
    }
}
