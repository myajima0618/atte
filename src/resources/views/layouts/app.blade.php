<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__title">
            <a href="/">Atte</a>
        </div>
        <nav class="header-nav">
            <ul class="header-nav__inner">
                <li class="header-nav__item"><a href="/">ホーム</a></li>
                <li class="header-nav__item"><a href="/attendance">日付一覧</a></li>
                <li class="header-nav__item">
                    <form action="/logout" method="post" name="logout">
                        @csrf
                        <a href="#" onclick="document.logout.submit();">ログアウト</a>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <small class="copyright">Atte, inc</small>
    </footer>

</body>

</html>