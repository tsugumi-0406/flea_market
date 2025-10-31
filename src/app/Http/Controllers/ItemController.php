<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Like;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Account;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommendation'); // デフォルトは recommendation

        switch ($tab) {
            case 'mylist':
                // マイリストを取得（ログインしていない場合は空）
                $items = auth()->check()
                    ? auth()->user()->likes()->with('item')->get()->pluck('item')
                    : collect();
                break;

            case 'recommendation':
            default:
                $items = Item::all();
                break;
        }

        return view('index', compact('items', 'tab'));
    }

    // 商品詳細画面の表示
    public function detail($item_id)
    {
        $item = Item::with('comments')->findOrFail($item_id);
        return view('detail', compact('item'));
    }

    // 購入画面の表示
    public function purchase($item_id)
    {
        $item = Item::find($item_id);
        // Accountsテーブルでユーザー情報を検索
        $user = Auth::user();
        $account = \App\Models\Account::where('user_id', $user->id)->first();
        return view('purchase', compact('item', 'account'));
    }

    // 購入
    public function order(Request $request)
    {
        $order = $request->all();
        Order::create($order);
        return redirect('/');
    }



    public function sell()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    public function listing(ExhibitionRequest $request)
    {
        $item = $request->all();
        $item['account_id'] = Auth::id();

        $item['image'] = 'noimage.png';


         if ($request->hasFile('image')) {
            $path = $request->file('image')->store('item_image', 'public');
            $item['image'] = $path;
        }

        Item::create($item);
        return redirect('/');
    }
}

