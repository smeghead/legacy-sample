<?php
declare(strict_types=1);
?>
<h1>新規作成</h1>

<form method="POST" action="{{ route('issue.store') }}">
  @csrf

  <div>
    <label for="form-summary">件名</label>
    <input type="text" name="summary" id="form-summary" required value="{{ old('summary') }}">
    @error('summary')
        {{ $message }}
    @enderror
  </div>

  <div>
    <label for="form-description">内容</label>
    <input type="text" name="description" id="form-description" required value="{{ old('description') }}">
    @error('description')
        {{ $message }}
    @enderror
  </div>

  <button type="submit">登録</button>
  <a href="{{ route('issue.index') }}">{{ __('一覧へ戻る') }}</a>
</form>