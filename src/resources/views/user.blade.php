@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
<div class="user-list">
    <h2 class="user-list__title">ユーザー一覧</h2>
    <table class="user-list__inner">
        <tr class="user-list__row">
            <th class="user-list__header">NO</th>
            <th class="user-list__header">名前</th>
            <th class="user-list__header">メールアドレス</th>
            <th class="user-list__header"></th>
        </tr>
        @foreach($users as $user)
        <tr class="user-list__row">
            <td class="user-list__item">{{ $users->firstItem() + $loop->index }}</td>
            <td class="user-list__item w30">{{ $user['name'] }}</td>
            <td class="user-list__item w50">{{ $user['email'] }}</td>
            <td class="user-list__item"><a href="/user/detail?id={{ $user['id'] }}&page={{ $users->currentPage() }}" class="user-list__button">詳細</a></td>
        </tr>
        @endforeach
    </table>
</div>

{{ $users->links('vendor.pagination.bootstrap-4') }}


@endsection