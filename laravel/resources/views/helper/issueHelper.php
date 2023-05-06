<?php

declare(strict_types=1);

function get_issue_class(?string $deadline): string
{
    if (empty($deadline)) {
        return '';
    }
    $d = new \DateTimeImmutable($deadline);
    $today = new \DateTimeImmutable('today');
    if ($d == $today) {
        return 'today';
    } else if ($d < $today) {
        return 'dead';
    } else if ($d < $today->add(new \DateInterval('P3D'))) {
        return 'soon';
    }
    return '';
}