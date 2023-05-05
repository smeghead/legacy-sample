<h1>編集</h1>

<form method="POST" action="{{ route('issue.update', ['issue' => $issue->id]) }}">
    @method('PUT')
    @csrf

    <div>
        件名
        <input type="text" name="summary" value="{{ $issue->summary }}">
        @error('summary')
            {{ $message }}
        @enderror
    </div>

    <div>
        内容
        <input type="text" name="description" value="{{ $issue->description }}">
        @error('description')
            {{ $message }}
        @enderror
    </div>

    <div>
        状態
        <input type="text" name="status" value="{{ $issue->status}}">
        @error('status')
            {{ $message }}
        @enderror
    </div>


    <input type="submit" value="更新する">
    <a href="{{ route('issue.index') }}">{{ __('一覧へ戻る') }}</a>

</form>