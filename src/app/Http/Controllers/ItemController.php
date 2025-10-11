<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;


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

    public function detail($item_id)
    {
        $item = Item::with('comments')->findOrFail($item_id);
        return view('detail', compact('item'));
    }
}

