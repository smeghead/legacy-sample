<?php

declare(strict_types=1);
?>
<h1>一覧表示</h1>
<a href="{{ route('issue.create') }}">{{ __('新規作成') }}</a>
<form method="GET" action="{{ route('issue.search') }}">
  @csrf
  <div>
    <label for="form-search">検索</label>
    <input type="search" name="q" id="form-search" value="{{ request()->query('q') }}">
  </div>

  <button type="submit">検索</button>
</form>

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
    <td>
      {{ ['opened' => '新規', 'working' => '作業中', 'done' => '完了'][$issue->status] }}
    </td>
    <td>{{$issue->description}}</td>
    <td><a href="{{ route('issue.show', ['issue' => $issue->id]) }}">詳細</a></td>
  </tr>
  @endforeach
</table>
{{ $issues->links() }}