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
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ExhibitionRequest;


class ItemController extends Controller
{
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

    public function index(Request $request)
{
    $tab = $request->query('tab', 'recommendation');
    $keyword = $request->keyword;
    $user = Auth::user();

    switch ($tab) {

        case 'mylist':
            if (!auth()->check()) {
                $items = collect();
                break;
            }

            $account = $user->account;

            if ($account) {
                // マイリスト内を keyword で検索
                $items = $account->likes()
                    ->with(['item' => function($q) use ($keyword){
                        if ($keyword) {
                            $q->KeywordSearch($keyword);
                        }
                    }])
                    ->get()
                    ->pluck('item')
                    ->filter(); // null除去
            } else {
                $items = collect();
            }

            break;

        case 'recommendation':
        default:
            $query = Item::with('order');

            if ($keyword) {
                $query->KeywordSearch($keyword);
            }

            if ($user && $user->account) {
                $query->where('account_id', '!=', $user->account->id);
            }

            $items = $query->get();
    }

    return view('index', compact('items', 'tab'))
            ->with('keyword', $keyword);
}

 
    // 商品詳細画面の表示
    public function detail($item_id)
    {
        $item = Item::with('comments.account', 'likes')->findOrFail($item_id);
        $category = Category::find($item_id);
        $likes_count = $item->likes->count();
        
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
    public function order(PurchaseRequest $request)
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

    // stripe決済に接続
    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $item = Item::findOrFail($request->item_id);

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/success'),
            'cancel_url' => url('/cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }

    // 商品出品ページの表示
    public function sell()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }

    // 商品を出品する
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

     // コメントを送信する
    public function comment(CommentRequest $request)
    {
        $user = Auth::user();
        $account = \App\Models\Account::where('user_id', $user->id)->first();

        $comment['sentence'] = $request->sentence;
        $comment['item_id'] = $request->item_id;
        $comment['account_id'] = $account->id;

        Comment::create($comment);

        return redirect()->route('item.detail', ['item_id' => $request->item_id]);
    }

    // いいね機能
    public function like(Item $item_id)
    {
        $user = Auth::user();
        $account = \App\Models\Account::where('user_id', $user->id)->first();
        $account_id = $account['id'];

        // ログインユーザーがその投稿をいいねしているレコードを取得
        $liked_item = $item_id->likes()->where('account_id', $account_id);

        // 既に「いいね」しているか確認
        if (!$liked_item->exists()) {

            //「いいね」していない場合は，likesテーブルにレコードを追加
            $like = new Like();
            $like->account_id = $account_id;
            $like->item_id = $item_id->id;
            $like->save();
        } else {
            // 既に「いいね」をしていた場合は，likesテーブルからレコードを削除     
            $liked_item->delete();
        }

        // いいねの数を取得
        $likes_count = $item_id->likes->count();

        
        $param = [
            'likes_count' => $likes_count, // いいねの数
        ];

        // フロントにいいねの数を返す
        return response()->json($param);
    }
}

