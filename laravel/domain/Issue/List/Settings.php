<?php

declare(strict_types=1);

namespace Domain\Issue\List;

/**
 * 課題一覧の設定
 */
final class Settings {
    public function __construct()
    {
    }

    /**
     * @return string[] 一覧の項目一覧
     */
    public function getListFields(): array
    {
        return ['id', 'summary', 'deadline', 'description', 'status'];
    }

    public function getCountParPage(): int
    {
        return 3;
    }
}