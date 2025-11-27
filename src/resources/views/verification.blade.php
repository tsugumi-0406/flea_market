<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verification.css') }}">
</head>

<body>
    <header class="header">
        <img src="{{ asset('storage/logo.svg') }}" alt="アプリロゴ" class="header__logo">
    </header>

    <main>
        <div class="main-sentence">
            <p class="main-sente__text">登録されたメールアドレスに確認メールを送付しました。</p>
            <p class="main-sente__text">メール内のリンクをクリックして認証を完了してください。</p>
            <!-- メール認証ページへ遷移 -->
            <a href="{{ route('verification.notice') }}" class="main-form__button">
                認証はこちらから
            </a>

            <!-- 再送ボタン -->
            <form method="POST" action="{{ route('verification.send') }}" class="main-form">
            @csrf
                <button class="main-form__button">認証メールを再送する</button>
            </form>
        </div>
    </main>
</body>

</html>
