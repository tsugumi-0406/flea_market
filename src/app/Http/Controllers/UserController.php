<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Order;
use App\Models\Like;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
 public function address($item_id)
    {
        // 商品データを取得
        $item = Item::findOrFail($item_id);

        // ログイン中ユーザー情報を取得
        $user = Auth::user();

        // ユーザーのアカウント情報を取得
        $account = Account::where('user_id', $user->id)->first();

        // ビューに $item と $account を渡す
        return view('address', compact('item', 'account'));
    }



     // 商品購入の際の送付先の変更
    public function updateAddress(AddressRequest $request, $item_id)
    {
        $item = Item::find($item_id);
        $user = Auth::user();
        $account = \App\Models\Account::where('user_id', $user->id)->first();
        
        $account->post_code = $request->input('post_code');
        $account->address   = $request->input('address');
        $account->building  = $request->input('building');
        return view('purchase', compact('item', 'account'));
    }




    public function mypage(Request $request)
    {
        $user = Auth::user();

        // Accountsテーブルでユーザー情報を検索
        $account = \App\Models\Account::where('user_id', $user->id)->first();

         $page = $request->query('page', 'sell');
        switch ($page) {
            case 'buy':
                $user = Auth::user();
                $account = \App\Models\Account::where('user_id', $user->id)->first();
                $orders = Order::where('account_id', $account->id)->with('item')->get();
                $items = $orders->pluck('item');
            break;

            case 'sell':
            default:
                $user = Auth::user();
                $account = \App\Models\Account::where('user_id', $user->id)->first();

                $items = Item::where('account_id', $account->id)->get();
            break;
        }
        return view('mypage', compact('items', 'page', 'account'));
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



    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->only(['name', 'post_code', 'address', 'building', 'image']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('account_image', 'public');
            $data['image'] = $path;
        }

        // ✅ データが存在すれば更新、無ければ新規作成
        if ($user->account) {
            // 更新
            $user->account->update($data);
        } else {
            // 新規作成（user_id自動で付与）
            $user->account()->create($data);
        }

        return redirect('/mypage');
    }

   
}
