@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<script>
    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
<div class="attendance-date">
    <div class="attendance-date__prev">
        <a href="/attendance?date={{ $prev_day }}">
            &#60;
        </a>
    </div>
    <form action="/attendance" method="get" class="attendance-date__selected">
        @csrf
        <div>
            <input type="text" id="datepicker" value="{{ $date }}" name="date" onchange="this.form.submit()">
        </div>
    </form>
    <div class="attendance-date__next">
        <a href="/attendance?date={{ $next_day }}">
            &#62;
        </a>
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
        <tr class="attendance-list__row" id="data-list">
            <td class="attendance-list__item">{{ $attendance['user']['name'] }}</td>
            <td class="attendance-list__item">{{ $attendance['check_in_time']}}</td>
            <td class="attendance-list__item">
                @if($attendance['check_out_time'] != null)
                    {{ $attendance['check_out_time'] }}
                @else
                     - 
                @endif
            </td>
            <td class="attendance-list__item">{{ $attendance['rest']['total_rests'] }}</td>
            <td class="attendance-list__item">{{ $attendance['work']['total_works'] }}</td>
        </tr>
        @endforeach
    </table>
    {{ $attendances->links('vendor.pagination.bootstrap-4') }}
</div>
@endsection