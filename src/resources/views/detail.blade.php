@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="page-back">
    <a href="/user?page={{ $page }}">ユーザー一覧へ戻る</a>
</div>
<div class="detail-list">
    <div class="detail-list__months">
        <a href="/user/detail?page={{ $page }}&id={{ $id }}&month={{ $month->subMonthNoOverflow() }}">&#60;</a>
        <a href="/user/detail?page={{ $page }}&id={{ $id }}&month={{ $month->subMonthNoOverflow(2) }}">
            {{ $month->subMonthNoOverflow(2)->format('Y年m月') }}
        </a>
        <a href="/user/detail?page={{ $page }}&id={{ $id }}&month={{ $month->subMonthNoOverflow() }}">
            {{ $month->subMonthNoOverflow()->format('Y年m月') }}
        </a>
        <a href="/user/detail" class="detail-list__months--selected">
            {{ $month->format('Y年m月') }}
        </a>
        <a href="/user/detail?page={{ $page }}&id={{ $id }}&month={{ $month->addMonthNoOverflow() }}">
            {{ $month->addMonthNoOverflow()->format('Y年m月') }}
        </a>
        <a href="/user/detail?page={{ $page }}&id={{ $id }}&month={{ $month->addMonthNoOverflow(2) }}">
            {{ $month->addMonthNoOverflow(2)->format('Y年m月') }}
        </a>
        <a href="/user/detail?page={{ $page }}&id={{ $id }}&month={{ $month->addMonthNoOverflow() }}">&#62;</a>
    </div>
    <div class="detail-list__title">
        <h2 class="detail-list__user">
            名前：{{ $user['name'] }}
        </h2>
    </div>
    <table class="detail-list__inner">
        <tr class="detail-list__row">
            <th class="detail-list__header">日付</th>
            <th class="detail-list__header">勤務開始</th>
            <th class="detail-list__header">勤務終了</th>
            <th class="detail-list__header">休憩時間</th>
            <th class="detail-list__header">勤務時間</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr class="detail-list__row">
            <td class="detail-list__item">{{ $attendance['date'] }}</td>
            <td class="detail-list__item">{{ $attendance['check_in_time'] }}</td>
            <td class="detail-list__item">{{ $attendance['check_out_time'] }}</td>
            <td class="detail-list__item">{{ $attendance['rest']['total_rests'] }}</td>
            <td class="detail-list__item">{{ $attendance['work']['total_works'] }}</td>
        </tr>
        @endforeach
    </table>
</div>

@endsection