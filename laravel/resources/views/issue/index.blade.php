<?php

declare(strict_types=1);

use Domain\Issue\IssueStatus;
use Domain\Issue\IssuePriority;

?>
@extends('layout.common')
@section('title', '一覧')

@section('content')
<h1>一覧表示</h1>
<a class="btn btn-primary" href="{{ route('issue.create') }}">{{ __('新規作成') }}</a>
<form method="GET" action="{{ route('issue.search') }}">
    @csrf
    <div>
        <input type="search" name="q" id="form-search" value="{{ request()->query('q') }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-secondary">検索</button>
</form>

<table class="table">
    <tr>
        <th>ID</th>
        <th>件名</th>
        <th>状態</th>
        <th>期限</th>
        <th>内容</th>
        <th></th>
    </tr>
    @foreach($issues as $issue)
    <?php
        $status = IssueStatus::createFromValue($issue->status);
        $priority = new IssuePriority(new \DateTimeImmutable('today'), $status, $issue->deadline);
    ?>
    <tr class="{{ $priority->value() }}">
        <td>{{$issue->id}}</td>
        <td>{{$issue->summary}}</td>
        <td>
            {{ $status->name() }}
        </td>
        <td>{{$issue->deadline}}</td>
        <td>{{$issue->description}}</td>
        <td><a href="{{ route('issue.show', ['issue' => $issue->id]) }}">詳細</a></td>
    </tr>
    @endforeach
</table>
{{ $issues->links() }}
@endsection