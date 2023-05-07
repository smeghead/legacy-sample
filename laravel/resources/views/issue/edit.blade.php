<?php
declare(strict_types=1);
?>
@extends('layout.common')
@section('title', '一覧')

@section('content')

<h1>編集</h1>

<form method="POST" action="{{ route('issue.update', ['issue' => $issue->id]) }}">
    @method('PUT')
    @csrf

    <div>
        件名
        <input type="text" name="summary" value="{{ $issue->summary }}" class="form-control">
        @error('summary')
            {{ $message }}
        @enderror
    </div>

    <div>
        内容
        <input type="text" name="description" value="{{ $issue->description }}" class="form-control">
        @error('description')
            {{ $message }}
        @enderror
    </div>

    <div>
        期限
        <input type="date" name="deadline" value="{{ $issue->deadline }}" class="form-control">
        @error('deadline')
            {{ $message }}
        @enderror
    </div>

    <div>
        状態
        <select name="status" class="form-control">
            @foreach ($status->getNextStatuses() as $next)
                <option value="{{$next->value()}}" @selected(old('status') == $next->value())>
                    {{ $next->name() }}
                </option>
            @endforeach
        </select>
        @error('status')
            {{ $message }}
        @enderror
    </div>


    <input type="submit" class="btn btn-primary" value="更新する">
    <a class="btn btn-secondary" href="{{ route('issue.index') }}">{{ __('一覧へ戻る') }}</a>

</form>
@endsection