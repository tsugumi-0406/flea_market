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
        $user = Auth::user();

        switch ($tab) {
            case 'mylist':
                // マイリストを取得（ログインしていない場合は空）
                $items = auth()->check()
                    ? auth()->user()->likes()->with('item.order')->get()->pluck('item')
                    : collect();
                break;

            case 'recommendation':
            default:
                if ($user) {
                $account = \App\Models\Account::where('user_id', $user->id)->first();
                $items = Item::with('order')
                    ->where('account_id', '!=', $account->id) // ← idがログインしている人のもの以外を取得
                    ->get();
                } else {
                    // 未ログインなら全件表示
                    $items = Item::with('order')->get();
                }
        }

        return view('index', compact('items', 'tab'));
    }

    // 商品検索機能
    public function search(Request $request)
    {
        $items = Item::query()
            ->KeywordSearch($request->keyword)->get();
        $tab = 'recommendation';

        return view('index', compact('items', 'tab'))
            ->with([
                'keyword' => $request->keyword,
            ]);
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
        $item = Item::findOrFail($item_id);
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

    public function createCheckoutSession(Request $request)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $item = Item::find($request->item_id);

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $item->name,
                ],
                'unit_amount' => $item->price * 100,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('payment.success'),
        'cancel_url' => route('payment.cancel'),
    ]);

    return response()->json(['id' => $session->id]);
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

