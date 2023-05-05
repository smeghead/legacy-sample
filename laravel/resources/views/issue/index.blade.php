<h1>一覧表示</h1>
<a href="{{ route('issue.create') }}">{{ __('新規作成') }}</a>

<table>
    <tr>
        <th>ID</th>
        <th>件名</th>
        <th>状態</th>
        <th>内容</th>
    </tr>
    @foreach($issues as $issue)
    <tr>
        <td>{{$issue->id}}</td>
        <td>{{$issue->summary}}</td>
        <td>{{$issue->status}}</td>
        <td>{{$issue->description}}</td>
        <td><a href="{{ route('issue.show', ['issue' => $issue->id]) }}">詳細</a></td>
    </tr>
    @endforeach
</table>
{{ $issues->links() }}
