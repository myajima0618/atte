@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection


@section('content')
@if(session('message'))
<div class="status__alert">
    <h4>{{ session('message') }}</h4>
</div>
@endif
<div class="user__info">
    @if(Auth::check())
    <h2>
        {{ $user['name'] }}さんお疲れ様です
    </h2>
    @endif
</div>
<div class="stamp-box">
    <form action="/" method="post" class="stamp-box__inner">
        @csrf
        <div class="stamp-box__item">
            @if($status == '0' or $status == '2')
            <button>勤務開始</button>
            @else
            <button disabled>勤務開始</button>
            @endif
        </div>
    </form>
    <form action="/" method="post" class="stamp-box__inner">
        @method('PATCH')
        @csrf
        <div class="stamp-box__item">
            @if($status == '1')
            <button>勤務終了</button>
            @else
            <button disabled>勤務終了</button>
            @endif
        </div>
    </form>
</div>
<div class="stamp-box">
    <form action="/rest" method="post" class="stamp-box__inner">
        @csrf
        <div class="stamp-box__item">
            @if($status == '1')
            <button>休憩開始</button>
            @else
            <button disabled>休憩開始</button>
            @endif
        </div>
    </form>
    <form action="/rest" method="post" class="stamp-box__inner">
        @method('PATCH')
        @csrf
        <div class="stamp-box__item">
            @if($status == '3')
            <button>休憩終了</button>
            @else
            <button disabled>休憩終了</button>
            @endif
        </div>
    </form>
</div>
@endsection