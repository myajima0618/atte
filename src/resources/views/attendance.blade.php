@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')<div class="attendance-date">
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
            @foreach($attendances as $attendance)
            <tr class="attendance-list__row">
                <td class="attendance-list__item">{{ $attendance['user']['name'] }}</td>
                <td class="attendance-list__item">{{ $attendance['check_in_time']}}</td>
                <td class="attendance-list__item">{{ $attendance['check_out_time'] }}</td>
                <td class="attendance-list__item">{{ $attendance['rest']['total_rests'] }}</td>
                <td class="attendance-list__item">{{ $attendance['work']['total_works'] }}</td>
            </tr>
            @endforeach
        </table>
        {{ $attendances->links() }}
    </div>
    <div class="attendance-list__page">

    </div>
    @endsection