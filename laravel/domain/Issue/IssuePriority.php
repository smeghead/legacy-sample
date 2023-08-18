<?php

declare(strict_types=1);

namespace Domain\Issue;

/**
 * Issueの優先度
 */
final class IssuePriority
{
    private string $value = '';

    /**
     * コンストラクタ
     * @param \DateTimeImmutable $baseDate 基準日
     * @param IssueStatus $status Issueの状態
     * @param ?string $deadline 期限
     */
    public function __construct(
        \DateTimeImmutable $baseDate,
        IssueStatus $status,
        ?string $deadline)
    {
        if ($status->closed()) {
            return;
        }
        if (empty($deadline)) {
            return;
        }
        try {
            $d = new \DateTimeImmutable($deadline);
            if ($d < $baseDate) {
                $this->value = 'dead';
            } else if ($d == $baseDate) {
                $this->value = 'today';
            } else if ($d < $baseDate->add(new \DateInterval('P4D'))) {
                $this->value = 'soon';
            }
        } catch (\Exception $e) {
            // DateTimeImmutableのコンストラクタに不正な日付文字列が渡された場合は例外が発生するが、
            // valueを空文字になるように何もしない
        }
    }

    /**
     * @return string 値
     */
    public function value(): string
    {
        return $this->value;
    }
}
