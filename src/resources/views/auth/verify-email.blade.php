@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="content__title--notice">
    <h3>仮登録完了</h3>
</div>

<div class="content__text">
    <h4>※登録はまだ完了しておりません</h4>
    <p>
        ご登録いただいたメールアドレスに本登録用のURLを記載したメールを送信いたしました。<br>
        メールに記載のURLをクリックし、登録を完了してください。
    </p>
    <form method="post" action="/email/verification-notification">
        @csrf
        <div class="content__resend">
            <button class="content__resend-submit">確認メール再送信</button>
        </div>
        @if(session('message'))
        <div class="content__resend-alert">
            <h4>{{ session('message') }}</h4>
        </div>
        @endif
    </form>
</div>
@endsection