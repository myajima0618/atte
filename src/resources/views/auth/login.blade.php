@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="content__title">
    <h3>ログイン</h3>
</div>
<form action="/login" method="post" novalidate>
    @csrf
    <div class="content-box">
        <div class="content-box__item">
            <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
        </div>
        <div class="content-box__error">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <div class="content-box__item">
            <input type="password" name="password" placeholder="パスワード">
        </div>
        <div class="content-box__error">
            @error('password')
            {{ $message }}
            @enderror
        </div>
        <div class="content-box__button">
            <button type="submit" class="content-box__button-submit">ログイン</button>
        </div>
        <div class="content-box__item">
            <p>アカウントをお持ちでない方はこちらから</p>
            <a href="/register">会員登録</a>
        </div>
    </div>
</form>
@endsection