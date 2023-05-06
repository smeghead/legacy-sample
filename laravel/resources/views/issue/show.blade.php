<?php
declare(strict_types=1);
?>
@extends('layout.common')
@section('title', '一覧')

@section('content')

<h1>詳細表示</h1>
<a class="btn btn-primary" href="{{ route('issue.edit', ['issue' => $issue->id]) }}">{{ __('編集') }}</a>
<div>
    件名
    {{$issue->summary}}
</div>

<div>
    電話番号
    {{$issue->description}}
</div>

<div>
    期限
    {{$issue->deadline}}
</div>

<div>
    状態
    {{$issue->status}}
</div>
<form method="POST" action="{{ route('issue.destroy', ['issue'=>$issue->id]) }}">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger">削除</button>
</form>

<a class="btn btn-secondary" href="{{ route('issue.index') }}">{{ __('一覧へ戻る') }}</a>
@endsection