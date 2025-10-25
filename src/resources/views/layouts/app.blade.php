<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flea_market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <img src="{{ asset('storage/logo.svg') }}" alt="アプリロゴ" class="header__logo" width="30%">
        <form action="" class="header-form">
            <input type="text" class="header-form__text" placeholder="何をお探しですか？">
        </form>
        @if (Auth::check())
            <form action="/logout" method="post">
             @csrf
                <button class="header-button__logout">ログアウト</button>
            </form>
        @else
            <a class="header-link__login" href="/login">ログイン</a>
        @endif
        <a class="header-link__mupage">マイページ</a>
        <a class="header-link__sell" href="/sell">出品</a>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>