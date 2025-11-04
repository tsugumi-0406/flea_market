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
use Stripe\Stripe;
use Stripe\Checkout\Session;


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
        $user = Auth::user();
        $account = \App\Models\Account::where('user_id', $user->id)->first();

        Order::create([
        'item_id'    => $request->item_id,
        'account_id' => $account->id,
        'method'     => 'stripe',
        'post_code' => $request->post_code,
        'address' => $request->address,
    ]);
        return redirect('/');
    }

    public function checkout(Request $request)
    {

        Stripe::setApiKey(config('services.stripe.secret'));

        $YOUR_DOMAIN = 'http://localhost:4242';

        $checkout_session = Session::create([
        'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'unit_amount' => $request->price * 100, // 例: 商品価格
                'product_data' => [
                    'name' => $request->item_name,       // 例: 商品名
                ],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        return redirect($checkout_session->url);
    }


// 商品出品ページの表示
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

