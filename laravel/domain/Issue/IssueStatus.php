<?php

declare(strict_types=1);

namespace Domain\Issue;

/**
 * Issueの状態
 */
class IssueStatus
{
    const NAMES = [
        'opened' => '新規',
        'working' => '作業中',
        'done' => '完了',
    ];

    /**
     * コンストラクタ
     * 外部からは呼び出せないようにします。
     * 初期状態を作成する時は、IssueStatus::create() を使ってください。
     * 値を指定する場合は、IssueStatus::createFromValue($value) を使ってください。
     */
    private function __construct(private string $value)
    {
        if (!in_array($value, array_keys(self::NAMES))) {
            throw new \Exception('invalid value.');
        }
    }

    /**
     * IssueStatusのインスタンスを生成します。
     * @return IssueStatus 状態の初期値を返却します。
     */
    public static function create(): self
    {
        return new self('opened'); // 初期値はopened
    }

    /**
     * 値を指定してIssueStatusのインスタンスを生成します。
     * @return IssueStatus 状態を返却します。
     */
    public static function createFromValue(string $value): self
    {
        return new self($value);
    }

    /**
     * @return string 値
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string 名前
     */
    public function name(): string
    {
        return self::NAMES[$this->value];
    }

    /**
     * この状態が次に取り得る状態の一覧を返却します。
     * @return self[] 現在のIssueStatusが、次に取り得るIssueStatusの一覧
     */
    public function getNextStatuses(): array
    {
        switch ($this->value) {
            case 'opened':
                return [$this, new self('working')];
            case 'working':
                return [$this, new self('done')];
            case 'done':
                return [$this];
            default:
                throw new \Exception('invalid value.');
        }
    }

    /**
     * クローズ状態かどうかを返却します。
     * @return bool クローズ状態かどうか
     */
    public function closed(): bool
    {
        return in_array($this->value, ['done']);
    }
}
