<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::loginView(fn() => view('login'));
        Fortify::registerView(fn() => view('profile'));

        // ✅ カスタム認証ロジックをFortifyに直接登録
        Fortify::authenticateUsing(function (Request $request) {
            // 🔸 バリデーション
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], [
                'email.required' => 'メールアドレスを入力してください。',
                'email.email' => '有効なメールアドレス形式で入力してください。',
                'password.required' => 'パスワードを入力してください。',
            ]);

            // 🔸 ユーザー検索
            $user = \App\Models\User::where('email', $request->email)->first();

            // 🔸 一致しない場合
            if (! $user || ! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                throw ValidationException::withMessages([
                    'email' => ['ログイン情報が登録されていません。'],
                ]);
            }

            // 🔸 成功時はユーザーを返す
            return $user;
        });

        // ✅ ログイン試行回数制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
