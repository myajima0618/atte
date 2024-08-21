@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="content__title">
    <h3>会員登録</h3>
</div>
<form action="/register" method="post" novalidate>
    @csrf
    <div class="content-box">
        <div class="content-box__item">
            <input type="text" name="name" placeholder="名前" value="{{ old('name') }}">
        </div>
        <div class="content-box__error">
            @error('name')
            {{ $message }}
            @enderror
        </div>
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
        <div class="content-box__item">
            <input type="password" name="password_confirmation" placeholder="確認用パスワード">
        </div>
        <div class="content-box__error">
            @error('password_confirmation')
            {{ $message }}
            @enderror
        </div>
        <div class="content-box__button">
            <button type="submit" class="content-box__button-submit">会員登録</button>
        </div>
        <div class="content-box__item">
            <p>アカウントをお持ちの方はこちらから</p>
            <a href="/login">ログイン</a>
        </div>
    </div>
</form>
@endsection