<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

    class LoginRequest extends FortifyLoginRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                'email' => ['required'],
                'password' => ['required']
            ];
        }

        public function messages()
        {
            return [
                'email.required' => 'メールアドレスを入力してください',
                'password.required' => 'パスワードを入力してください',
            ];
        }
        
        public function authenticate()
{
    // ✅ バリデーションをここで実行（手動）
    $this->validate(
        $this->rules(),
        $this->messages()
    );

    // ✅ ログイン試行回数チェック
    $this->ensureIsNotRateLimited();

    // ✅ 認証処理
    if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        throw ValidationException::withMessages([
            'email' => ['ログイン情報が登録されていません。'],
        ]);
    }

    // ✅ 成功したら制限解除
    rateLimiter()->clear($this->throttleKey());
}
    }