<?php
declare(strict_types=1);
?>
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
        <select name="status">
            @switch ($issue->status)
                @case('opened')
                    @foreach (['opened' => '新規', 'working' => '作業中'] as $key => $value)
                        <option value="{{$key}}" @selected(old('status') == $key)>
                            {{ $value }}
                        </option>
                    @endforeach
                    @break
                @case('working')
                    @foreach (['working' => '作業中', 'done' => '完了'] as $key => $value)
                        <option value="{{$key}}" @selected(old('status') == $key)>
                            {{ $value }}
                        </option>
                    @endforeach
                    @break
                @case('done')
                    @foreach (['done' => '完了'] as $key => $value)
                        <option value="{{$key}}" @selected(old('status') == $key)>
                            {{ $value }}
                        </option>
                    @endforeach
                    @break
                @endswitch
        </select>
        @error('status')
            {{ $message }}
        @enderror
    </div>


    <input type="submit" value="更新する">
    <a href="{{ route('issue.index') }}">{{ __('一覧へ戻る') }}</a>

</form>