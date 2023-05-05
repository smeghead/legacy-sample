<h1>詳細表示</h1>
<a href="{{route('issue.edit',['issue'=>$issue->id])}}">{{ __('編集') }}</a>
<div>
    件名
    {{$issue->summary}}
</div>

<div>
    電話番号
    {{$issue->description}}
</div>

<div>
    状態
    {{$issue->status}}
</div>
<form method="POST" action="{{ route('issue.destroy', ['issue'=>$issue->id]) }}">
    @method('DELETE')
    @csrf
    <button type="submit">削除</button>
</form>

<a href="{{ route('issue.index') }}">{{ __('一覧へ戻る') }}</a>