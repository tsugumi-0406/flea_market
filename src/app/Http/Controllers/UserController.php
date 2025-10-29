<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class UserController extends Controller
{

    // public function register()
    // {
    //     return view('register');
    // }


    public function address()
    {
        return view('address');
    }

    public function mypage(Request $request)
    {
         $page = $request->query('page', 'sell');
        switch ($page) {
            case 'buy':
                // マイリストを取得（ログインしていない場合は空）
                $items = auth()->check()
                    ? auth()->user()->likes()->with('item')->get()->pluck('item')
                    : collect();
                break;

            case 'sell':
            default:
                $items = Item::all();
                break;
        }
        return view('mypage', compact('items', 'page'));
    }

    // プロフィール画面にアカウントテーブルにデータがあれば表示する
    public function profile()
    {
        $user = Auth::user();

        // Accountsテーブルでユーザー情報を検索
        $account = \App\Models\Account::where('user_id', $user->id)->first();

        // データがなければ何も表示しない（ビューを分岐）
        if (!$account) {
            // 例1: 空画面を返す
            return view('profile', ['account' => null]);

            // 例2: 別ページにリダイレクトしたい場合
            // return redirect('/mypage')->with('warning', '登録情報がありません');
        }

        // 該当レコードがある場合のみ表示
        return view('profile', compact('account', 'user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->only(['name', 'post_code', 'address', 'building', 'image']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('account_image', 'public');
            $data['image'] = $path;
        }

        // ✅ データが存在すれば更新、無ければ新規作成
        if ($user->accounts) {
            // 更新
            $user->accounts->update($data);
        } else {
            // 新規作成（user_id自動で付与）
            $user->accounts()->create($data);
        }

        return redirect('/mypage');
    }
}
