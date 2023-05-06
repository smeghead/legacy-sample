<?php
declare(strict_types=1);
?>
@extends('layout.common')
@section('title', '一覧')

@section('content')

<h1>新規作成</h1>

<form method="POST" action="{{ route('issue.store') }}">
  @csrf

  <div>
    <label for="form-summary">件名</label>
    <input type="text" name="summary" id="form-summary" required value="{{ old('summary') }}" class="form-control">
    @error('summary')
        {{ $message }}
    @enderror
  </div>

  <div>
    <label for="form-description">内容</label>
    <input type="text" name="description" id="form-description" required value="{{ old('description') }}" class="form-control">
    @error('description')
        {{ $message }}
    @enderror
  </div>

  <div>
    <label for="form-deadline">期限</label>
    <input type="date" name="deadline" id="form-deadline" required value="{{ old('deadline') }}" class="form-control">
    @error('deadline')
        {{ $message }}
    @enderror
  </div>

  <button type="submit" class="btn btn-primary">登録</button>
  <a class="btn btn-secondary" href="{{ route('issue.index') }}">{{ __('一覧へ戻る') }}</a>
</form>
@endsection