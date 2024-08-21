@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance-date">
    <div class="attendance-date__prev">
        <
    </div>
    <div class="attendance-date__selected">
        <input type="date" value="{{ $date }}">
    </div>
    <div class="attendance-date__next">
        >
    </div>
</div>
<div class="attendance-list">
    <table class="attendance-list__inner">
        <tr class="attendance-list__row">
            <th class="attendance-list__header">名前</th>
            <th class="attendance-list__header">勤務開始</th>
            <th class="attendance-list__header">勤務終了</th>
            <th class="attendance-list__header">休憩時間</th>
            <th class="attendance-list__header">勤務時間</th>
        </tr>
        <tr class="attendance-list__row">
            <td class="attendance-list__item">テスト太郎</td>
            <td class="attendance-list__item">10:00:00</td>
            <td class="attendance-list__item">20:00:00</td>
            <td class="attendance-list__item">00:30:00</td>
            <td class="attendance-list__item">09:30:00</td>
        </tr>
        <tr class="attendance-list__row">
            <td class="attendance-list__item">テスト次郎</td>
            <td class="attendance-list__item">10:00:10</td>
            <td class="attendance-list__item">20:00:00</td>
            <td class="attendance-list__item">00:30:00</td>
            <td class="attendance-list__item">09:29:50</td>
        </tr>
        <tr class="attendance-list__row">
            <td class="attendance-list__item">テスト三郎</td>
            <td class="attendance-list__item">10:00:10</td>
            <td class="attendance-list__item">20:00:00</td>
            <td class="attendance-list__item">00:30:00</td>
            <td class="attendance-list__item">09:29:50</td>
        </tr>
        <tr class="attendance-list__row">
            <td class="attendance-list__item">テスト四郎</td>
            <td class="attendance-list__item">10:00:20</td>
            <td class="attendance-list__item">20:00:00</td>
            <td class="attendance-list__item">00:30:00</td>
            <td class="attendance-list__item">09:29:40</td>
        </tr>
        <tr class="attendance-list__row">
            <td class="attendance-list__item">テスト五郎</td>
            <td class="attendance-list__item">10:00:20</td>
            <td class="attendance-list__item">20:00:00</td>
            <td class="attendance-list__item">00:30:00</td>
            <td class="attendance-list__item">09:29:40</td>
        </tr>
    </table>
</div>
<div class="attendance-list__page">

</div>
@endsection